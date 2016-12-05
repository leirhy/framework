<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 19:41
 */
namespace Notadd\Foundation;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Notadd\Foundation\Bootstrap\DetectEnvironment;
use Notadd\Foundation\Event\EventServiceProvider;
use Notadd\Foundation\Routing\RoutingServiceProvider;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application.
 */
class Application extends Container implements ApplicationContract, HttpKernelInterface
{
    /**
     * @var string
     */
    const VERSION = '1.0';

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var bool
     */
    protected $hasBeenBootstrapped = false;

    /**
     * @var bool
     */
    protected $booted = false;

    /**
     * @var array
     */
    protected $bootingCallbacks = [];

    /**
     * @var array
     */
    protected $bootedCallbacks = [];

    /**
     * @var array
     */
    protected $terminatingCallbacks = [];

    /**
     * @var array
     */
    protected $serviceProviders = [];

    /**
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * @var array
     */
    protected $deferredServices = [];

    /**
     * @var callable|null
     */
    protected $monologConfigurator;

    /**
     * @var string
     */
    protected $databasePath;

    /**
     * @var string
     */
    protected $publicPath;

    /**
     * @var string
     */
    protected $storagePath;

    /**
     * @var string
     */
    protected $environmentPath;

    /**
     * @var string
     */
    protected $environmentFile = '.env';

    /**
     * @var string
     */
    protected $namespace = null;

    /**
     * @param string|null $basePath
     */
    public function __construct($basePath = null)
    {
        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
        $this->registerCoreContainerAliases();
        if ($basePath) {
            $this->setBasePath(realpath($basePath));
        }
    }

    /**
     * TODO: Method version Description
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * TODO: Method registerBaseBindings Description
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance('Illuminate\Container\Container', $this);
    }

    /**
     * TODO: Method registerBaseServiceProviders Description
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new RoutingServiceProvider($this));
    }

    /**
     * TODO: Method bootstrapWith Description
     *
     * @param array $bootstrappers
     */
    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;
        foreach ($bootstrappers as $bootstrapper) {
            $this['events']->fire('bootstrapping: ' . $bootstrapper, [$this]);
            $this->make($bootstrapper)->bootstrap($this);
            $this['events']->fire('bootstrapped: ' . $bootstrapper, [$this]);
        }
    }

    /**
     * TODO: Method afterLoadingEnvironment Description
     *
     * @param \Closure $callback
     */
    public function afterLoadingEnvironment(Closure $callback)
    {
        return $this->afterBootstrapping(DetectEnvironment::class, $callback);
    }

    /**
     * TODO: Method beforeBootstrapping Description
     *
     * @param          $bootstrapper
     * @param \Closure $callback
     */
    public function beforeBootstrapping($bootstrapper, Closure $callback)
    {
        $this['events']->listen('bootstrapping: ' . $bootstrapper, $callback);
    }

    /**
     * TODO: Method afterBootstrapping Description
     *
     * @param          $bootstrapper
     * @param \Closure $callback
     */
    public function afterBootstrapping($bootstrapper, Closure $callback)
    {
        $this['events']->listen('bootstrapped: ' . $bootstrapper, $callback);
    }

    /**
     * TODO: Method hasBeenBootstrapped Description
     *
     * @return bool
     */
    public function hasBeenBootstrapped()
    {
        return $this->hasBeenBootstrapped;
    }

    /**
     * TODO: Method setBasePath Description
     *
     * @param $basePath
     *
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * TODO: Method bindPathsInContainer Description
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.lang', $this->langPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
    }

    /**
     * TODO: Method path Description
     *
     * @return string
     */
    public function path()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'src';
    }

    /**
     * TODO: Method basePath Description
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * TODO: Method bootstrapPath Description
     *
     * @return string
     */
    public function bootstrapPath()
    {
        return $this->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps';
    }

    /**
     * TODO: Method configPath Description
     *
     * @return string
     */
    public function configPath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'configurations';
    }

    /**
     * TODO: Method databasePath Description
     *
     * @return string
     */
    public function databasePath()
    {
        return $this->databasePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'databases';
    }

    /**
     * TODO: Method useDatabasePath Description
     *
     * @param $path
     *
     * @return $this
     */
    public function useDatabasePath($path)
    {
        $this->databasePath = $path;
        $this->instance('path.database', $path);

        return $this;
    }

    /**
     * TODO: Method langPath Description
     *
     * @return string
     */
    public function langPath()
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'translations';
    }

    /**
     * TODO: Method publicPath Description
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->publicPath ?: $this->basePath . DIRECTORY_SEPARATOR . 'public';
    }

    /**
     * TODO: Method usePublicPath Description
     *
     * @param $path
     *
     * @return $this
     */
    public function usePublicPath($path)
    {
        $this->publicPath = $path;
        $this->instance('path.public', $path);

        return $this;
    }

    /**
     * TODO: Method storagePath Description
     *
     * @return string
     */
    public function storagePath()
    {
        return $this->storagePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'storage';
    }

    /**
     * TODO: Method useStoragePath Description
     *
     * @param $path
     *
     * @return $this
     */
    public function useStoragePath($path)
    {
        $this->storagePath = $path;
        $this->instance('path.storage', $path);

        return $this;
    }

    /**
     * TODO: Method resourcePath Description
     *
     * @return string
     */
    public function resourcePath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'resources';
    }

    /**
     * TODO: Method environmentPath Description
     *
     * @return string
     */
    public function environmentPath()
    {
        return $this->environmentPath ?: $this->storagePath() . DIRECTORY_SEPARATOR . 'environments';
    }

    /**
     * TODO: Method useEnvironmentPath Description
     *
     * @param $path
     *
     * @return $this
     */
    public function useEnvironmentPath($path)
    {
        $this->environmentPath = $path;

        return $this;
    }

    /**
     * TODO: Method loadEnvironmentFrom Description
     *
     * @param $file
     *
     * @return $this
     */
    public function loadEnvironmentFrom($file)
    {
        $this->environmentFile = $file;

        return $this;
    }

    /**
     * TODO: Method environmentFile Description
     *
     * @return string
     */
    public function environmentFile()
    {
        return $this->environmentFile ?: '.env';
    }

    /**
     * TODO: Method environmentFilePath Description
     *
     * @return string
     */
    public function environmentFilePath()
    {
        return $this->environmentPath() . DIRECTORY_SEPARATOR . $this->environmentFile();
    }

    /**
     * TODO: Method environment Description
     *
     * @return bool|mixed
     */
    public function environment()
    {
        if (func_num_args() > 0) {
            $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();
            foreach ($patterns as $pattern) {
                if (Str::is($pattern, $this['env'])) {
                    return true;
                }
            }

            return false;
        }

        return $this['env'];
    }

    /**
     * TODO: Method isLocal Description
     *
     * @return bool
     */
    public function isLocal()
    {
        return $this['env'] == 'local';
    }

    /**
     * TODO: Method detectEnvironment Description
     *
     * @param \Closure $callback
     *
     * @return string
     */
    public function detectEnvironment(Closure $callback)
    {
        $args = isset($_SERVER['argv']) ? $_SERVER['argv'] : null;

        return $this['env'] = (new EnvironmentDetector())->detect($callback, $args);
    }

    /**
     * TODO: Method runningInConsole Description
     *
     * @return bool
     */
    public function runningInConsole()
    {
        return php_sapi_name() == 'cli';
    }

    /**
     * TODO: Method runningUnitTests Description
     *
     * @return bool
     */
    public function runningUnitTests()
    {
        return $this['env'] == 'testing';
    }

    /**
     * TODO: Method registerConfiguredProviders Description
     */
    public function registerConfiguredProviders()
    {
        $manifestPath = $this->getCachedServicesPath();
        (new ProviderRepository($this, new Filesystem(), $manifestPath))->load($this->config['app.providers']);
    }

    /**
     * TODO: Method register Description
     *
     * @param \Illuminate\Support\ServiceProvider|string $provider
     * @param array                                      $options
     * @param bool                                       $force
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register($provider, $options = [], $force = false)
    {
        if (($registered = $this->getProvider($provider)) && !$force) {
            return $registered;
        }
        if (is_string($provider)) {
            $provider = $this->resolveProviderClass($provider);
        }
        if (method_exists($provider, 'register')) {
            $provider->register();
        }
        foreach ($options as $key => $value) {
            $this[$key] = $value;
        }
        $this->markAsRegistered($provider);
        if ($this->booted) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    /**
     * TODO: Method getProvider Description
     *
     * @param \Illuminate\Support\ServiceProvider|string $provider
     *
     * @return \Illuminate\Support\ServiceProvider|null
     */
    public function getProvider($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::first($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    /**
     * TODO: Method resolveProviderClass Description
     *
     * @param string $provider
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function resolveProviderClass($provider)
    {
        return new $provider($this);
    }

    /**
     * TODO: Method markAsRegistered Description
     *
     * @param \Illuminate\Support\ServiceProvider $provider
     *
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this['events']->fire($class = get_class($provider), [$provider]);
        $this->serviceProviders[] = $provider;
        $this->loadedProviders[$class] = true;
    }

    /**
     * TODO: Method loadDeferredProviders Description
     *
     * @return void
     */
    public function loadDeferredProviders()
    {
        foreach ($this->deferredServices as $service => $provider) {
            $this->loadDeferredProvider($service);
        }
        $this->deferredServices = [];
    }

    /**
     * TODO: Method loadDeferredProvider Description
     *
     * @param $service
     */
    public function loadDeferredProvider($service)
    {
        if (!isset($this->deferredServices[$service])) {
            return;
        }
        $provider = $this->deferredServices[$service];
        if (!isset($this->loadedProviders[$provider])) {
            $this->registerDeferredProvider($provider, $service);
        }
    }

    /**
     * TODO: Method registerDeferredProvider Description
     *
     * @param string $provider
     * @param null   $service
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        if ($service) {
            unset($this->deferredServices[$service]);
        }
        $this->register($instance = new $provider($this));
        if (!$this->booted) {
            $this->booting(function () use ($instance) {
                $this->bootProvider($instance);
            });
        }
    }

    /**
     * TODO: Method make Description
     *
     * @param string $abstract
     * @param array  $parameters
     *
     * @return mixed
     */
    public function make($abstract, array $parameters = [])
    {
        $abstract = $this->getAlias($abstract);
        if (isset($this->deferredServices[$abstract])) {
            $this->loadDeferredProvider($abstract);
        }

        return parent::make($abstract, $parameters);
    }

    /**
     * TODO: Method bound Description
     *
     * @param string $abstract
     *
     * @return bool
     */
    public function bound($abstract)
    {
        return isset($this->deferredServices[$abstract]) || parent::bound($abstract);
    }

    /**
     * TODO: Method isBooted Description
     *
     * @return bool
     */
    public function isBooted()
    {
        return $this->booted;
    }

    /**
     * TODO: Method boot Description
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }
        $this->fireAppCallbacks($this->bootingCallbacks);
        array_walk($this->serviceProviders, function ($p) {
            $this->bootProvider($p);
        });
        $this->booted = true;
        $this->fireAppCallbacks($this->bootedCallbacks);
    }

    /**
     * TODO: Method bootProvider Description
     *
     * @param \Illuminate\Support\ServiceProvider $provider
     *
     * @return mixed
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([
                $provider,
                'boot',
            ]);
        }
    }

    /**
     * TODO: Method booting Description
     *
     * @param mixed $callback
     */
    public function booting($callback)
    {
        $this->bootingCallbacks[] = $callback;
    }

    /**
     * TODO: Method booted Description
     *
     * @param mixed $callback
     */
    public function booted($callback)
    {
        $this->bootedCallbacks[] = $callback;
        if ($this->isBooted()) {
            $this->fireAppCallbacks([$callback]);
        }
    }

    /**
     * TODO: Method fireAppCallbacks Description
     *
     * @param array $callbacks
     */
    protected function fireAppCallbacks(array $callbacks)
    {
        foreach ($callbacks as $callback) {
            call_user_func($callback, $this);
        }
    }

    /**
     * TODO: Method handle Description
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int                                       $type
     * @param bool                                      $catch
     *
     * @return mixed
     */
    public function handle(SymfonyRequest $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return $this['Illuminate\Contracts\Http\Kernel']->handle(Request::createFromBase($request));
    }

    /**
     * TODO: Method shouldSkipMiddleware Description
     *
     * @return bool
     */
    public function shouldSkipMiddleware()
    {
        return $this->bound('middleware.disable') && $this->make('middleware.disable') === true;
    }

    /**
     * TODO: Method configurationIsCached Description
     *
     * @return bool
     */
    public function configurationIsCached()
    {
        return file_exists($this->getCachedConfigPath());
    }

    /**
     * TODO: Method getCachedConfigPath Description
     *
     * @return string
     */
    public function getCachedConfigPath()
    {
        return $this->storagePath() . '/bootstraps/configurations.php';
    }

    /**
     * TODO: Method routesAreCached Description
     *
     * @return mixed
     */
    public function routesAreCached()
    {
        return $this['files']->exists($this->getCachedRoutesPath());
    }

    /**
     * TODO: Method getCachedRoutesPath Description
     *
     * @return string
     */
    public function getCachedRoutesPath()
    {
        return $this->storagePath() . '/bootstraps/routes.php';
    }

    /**
     * TODO: Method getCachedCompilePath Description
     *
     * @return string
     */
    public function getCachedCompilePath()
    {
        return $this->storagePath() . '/bootstraps/compiled.php';
    }

    /**
     * TODO: Method getCachedServicesPath Description
     *
     * @return string
     */
    public function getCachedServicesPath()
    {
        return $this->storagePath() . '/bootstraps/services.php';
    }

    /**
     * TODO: Method isDownForMaintenance Description
     *
     * @return bool
     */
    public function isDownForMaintenance()
    {
        return file_exists($this->storagePath() . '/bootstraps/down');
    }

    /**
     * TODO: Method abort Description
     *
     * @param int    $code
     * @param string $message
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @return void
     */
    public function abort($code, $message = '', array $headers = [])
    {
        if ($code == 404) {
            throw new NotFoundHttpException($message);
        }
        throw new HttpException($code, $message, null, $headers);
    }

    /**
     * TODO: Method terminating Description
     *
     * @param \Closure $callback
     *
     * @return $this
     */
    public function terminating(Closure $callback)
    {
        $this->terminatingCallbacks[] = $callback;

        return $this;
    }

    /**
     * TODO: Method terminate Description
     */
    public function terminate()
    {
        foreach ($this->terminatingCallbacks as $terminating) {
            $this->call($terminating);
        }
    }

    /**
     * TODO: Method getLoadedProviders Description
     *
     * @return array
     */
    public function getLoadedProviders()
    {
        return $this->loadedProviders;
    }

    /**
     * TODO: Method getDeferredServices Description
     *
     * @return array
     */
    public function getDeferredServices()
    {
        return $this->deferredServices;
    }

    /**
     * TODO: Method setDeferredServices Description
     *
     * @param array $services
     *
     * @return void
     */
    public function setDeferredServices(array $services)
    {
        $this->deferredServices = $services;
    }

    /**
     * TODO: Method addDeferredServices Description
     *
     * @param array $services
     *
     * @return void
     */
    public function addDeferredServices(array $services)
    {
        $this->deferredServices = array_merge($this->deferredServices, $services);
    }

    /**
     * TODO: Method isDeferredService Description
     *
     * @param string $service
     *
     * @return bool
     */
    public function isDeferredService($service)
    {
        return isset($this->deferredServices[$service]);
    }

    /**
     * TODO: Method configureMonologUsing Description
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function configureMonologUsing(callable $callback)
    {
        $this->monologConfigurator = $callback;

        return $this;
    }

    /**
     * TODO: Method hasMonologConfigurator Description
     *
     * @return bool
     */
    public function hasMonologConfigurator()
    {
        return !is_null($this->monologConfigurator);
    }

    /**
     * TODO: Method getMonologConfigurator Description
     *
     * @return callable
     */
    public function getMonologConfigurator()
    {
        return $this->monologConfigurator;
    }

    /**
     * TODO: Method getLocale Description
     *
     * @return string
     */
    public function getLocale()
    {
        return $this['config']->get('app.locale');
    }

    /**
     * TODO: Method setLocale Description
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        $this['config']->set('app.locale', $locale);
        $this['translator']->setLocale($locale);
        $this['events']->fire('locale.changed', [$locale]);
    }

    /**
     * TODO: Method isLocale Description
     *
     * @param string $locale
     *
     * @return bool
     */
    public function isLocale($locale)
    {
        return $this->getLocale() == $locale;
    }

    /**
     * TODO: Method registerCoreContainerAliases Description
     */
    public function registerCoreContainerAliases()
    {
        $aliases = [
            'administration'            => ['Notadd\Foundation\Administration\Administration'],
            'app'                       => [
                'Illuminate\Contracts\Container\Container',
                'Illuminate\Contracts\Foundation\Application',
                'Notadd\Foundation\Application',
            ],
            'auth'                      => [
                'Illuminate\Auth\AuthManager',
                'Illuminate\Contracts\Auth\Factory',
            ],
            'auth.driver'               => ['Illuminate\Contracts\Auth\Guard'],
            'auth.password'             => [
                'Illuminate\Auth\Passwords\PasswordBrokerManager',
                'Illuminate\Contracts\Auth\PasswordBrokerFactory',
            ],
            'auth.password.broker'      => [
                'Illuminate\Auth\Passwords\PasswordBroker',
                'Illuminate\Contracts\Auth\PasswordBroker',
            ],
            'blade.compiler'            => ['Illuminate\View\Compilers\BladeCompiler'],
            'cache'                     => [
                'Illuminate\Cache\CacheManager',
                'Illuminate\Contracts\Cache\Factory',
            ],
            'cache.store'               => [
                'Illuminate\Cache\Repository',
                'Illuminate\Contracts\Cache\Repository',
            ],
            'composer'                  => ['Illuminate\Support\Composer'],
            'config'                    => [
                'Illuminate\Contracts\Config\Repository',
                'Notadd\Foundation\Configuration\Repository',
            ],
            'cookie'                    => [
                'Illuminate\Cookie\CookieJar',
                'Illuminate\Contracts\Cookie\Factory',
                'Illuminate\Contracts\Cookie\QueueingFactory',
            ],
            'encrypter'                 => [
                'Illuminate\Encryption\Encrypter',
                'Illuminate\Contracts\Encryption\Encrypter',
            ],
            'db'                        => ['Illuminate\Database\DatabaseManager'],
            'db.connection'             => [
                'Illuminate\Database\Connection',
                'Illuminate\Database\ConnectionInterface',
            ],
            'extensions'                => ['Notadd\Foundation\Extension\ExtensionManager'],
            'events'                    => [
                'Illuminate\Events\Dispatcher',
                'Illuminate\Contracts\Events\Dispatcher',
            ],
            'files'                     => ['Illuminate\Filesystem\Filesystem'],
            'filesystem'                => [
                'Illuminate\Filesystem\FilesystemManager',
                'Illuminate\Contracts\Filesystem\Factory',
            ],
            'filesystem.disk'           => ['Illuminate\Contracts\Filesystem\Filesystem'],
            'filesystem.cloud'          => ['Illuminate\Contracts\Filesystem\Cloud'],
            'hash'                      => ['Illuminate\Contracts\Hashing\Hasher'],
            'translator'                => [
                'Illuminate\Translation\Translator',
                'Symfony\Component\Translation\TranslatorInterface',
            ],
            'log'                       => [
                'Illuminate\Log\Writer',
                'Illuminate\Contracts\Logging\Log',
                'Psr\Log\LoggerInterface',
            ],
            'mailer'                    => [
                'Illuminate\Mail\Mailer',
                'Illuminate\Contracts\Mail\Mailer',
                'Illuminate\Contracts\Mail\MailQueue',
            ],
            'member'                    => ['Notadd\Foundation\Member\MemberManagement'],
            'queue'                     => [
                'Illuminate\Queue\QueueManager',
                'Illuminate\Contracts\Queue\Factory',
                'Illuminate\Contracts\Queue\Monitor',
            ],
            'queue.connection'          => ['Illuminate\Contracts\Queue\Queue'],
            'queue.failer'              => ['Illuminate\Queue\Failed\FailedJobProviderInterface'],
            'redirect'                  => [
                'Illuminate\Routing\Redirector',
                'Notadd\Foundation\Routing\Redirector',
            ],
            'redis'                     => [
                'Illuminate\Redis\Database',
                'Illuminate\Contracts\Redis\Database',
            ],
            'request'                   => [
                'Illuminate\Http\Request',
                'Symfony\Component\HttpFoundation\Request',
            ],
            'router'                    => [
                'Illuminate\Routing\Router',
                'Illuminate\Contracts\Routing\Registrar',
            ],
            'searchengine.optimization' => ['Notadd\Foundation\SearchEngine\Optimization'],
            'session'                   => ['Illuminate\Session\SessionManager'],
            'session.store'             => [
                'Illuminate\Session\Store',
                'Symfony\Component\HttpFoundation\Session\SessionInterface',
            ],
            'setting'                   => ['Notadd\Foundation\Setting\Contracts\SettingsRepository'],
            'url'                       => [
                'Illuminate\Routing\UrlGenerator',
                'Illuminate\Contracts\Routing\UrlGenerator',
            ],
            'validator'                 => [
                'Illuminate\Validation\Factory',
                'Illuminate\Contracts\Validation\Factory',
            ],
            'view'                      => [
                'Illuminate\View\Factory',
                'Illuminate\Contracts\View\Factory',
            ],
        ];
        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    /**
     * TODO: Method flush Description
     */
    public function flush()
    {
        parent::flush();
        $this->loadedProviders = [];
    }

    /**
     * TODO: Method getNamespace Description
     *
     * @return string
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (!is_null($this->namespace)) {
            return $this->namespace;
        }
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        foreach ((array)data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array)$path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path() . '/' . $pathChoice)) {
                    return $this->namespace = $namespace;
                }
            }
        }
        throw new RuntimeException('Unable to detect application namespace.');
    }

    /**
     * TODO: Method isInstalled Description
     *
     * @return bool
     */
    public function isInstalled()
    {
        if ($this->bound('installed')) {
            return true;
        } else {
            if (file_exists($this->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps' . DIRECTORY_SEPARATOR . 'replace.php')) {
                $this->instance('installed', true);

                return true;
            } else {
                return false;
            }
        }
    }
}
