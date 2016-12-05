<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:16
 */
namespace Notadd\Foundation\Console\Commands;

use ClassPreloader\Exceptions\VisitorExceptionInterface;
use ClassPreloader\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class OptimizeCommand.
 */
class OptimizeCommand extends Command
{
    /**
     * @var array
     */
    protected $complies = [
        '/vendor/illuminate/contracts/Container/Container.php',
        '/vendor/illuminate/contracts/Container/ContextualBindingBuilder.php',
        '/vendor/illuminate/contracts/Foundation/Application.php',
        '/vendor/illuminate/contracts/Bus/Dispatcher.php',
        '/vendor/illuminate/contracts/Bus/QueueingDispatcher.php',
        '/vendor/illuminate/contracts/Pipeline/Pipeline.php',
        '/vendor/illuminate/contracts/Support/Renderable.php',
        '/vendor/illuminate/contracts/Logging/Log.php',
        '/vendor/illuminate/contracts/Debug/ExceptionHandler.php',
        '/vendor/illuminate/contracts/Config/Repository.php',
        '/vendor/illuminate/contracts/Events/Dispatcher.php',
        '/vendor/illuminate/contracts/Support/Arrayable.php',
        '/vendor/illuminate/contracts/Support/Jsonable.php',
        '/vendor/illuminate/contracts/Cookie/Factory.php',
        '/vendor/illuminate/contracts/Cookie/QueueingFactory.php',
        '/vendor/illuminate/contracts/Encryption/Encrypter.php',
        '/vendor/illuminate/contracts/Queue/QueueableEntity.php',
        '/vendor/illuminate/contracts/Routing/Registrar.php',
        '/vendor/illuminate/contracts/Routing/ResponseFactory.php',
        '/vendor/illuminate/contracts/Routing/UrlGenerator.php',
        '/vendor/illuminate/contracts/Routing/UrlRoutable.php',
        '/vendor/illuminate/contracts/Validation/ValidatesWhenResolved.php',
        '/vendor/illuminate/contracts/View/Factory.php',
        '/vendor/illuminate/contracts/Support/MessageProvider.php',
        '/vendor/illuminate/contracts/Support/MessageBag.php',
        '/vendor/illuminate/contracts/View/View.php',
        '/vendor/illuminate/contracts/Http/Kernel.php',
        '/vendor/illuminate/contracts/Auth/Guard.php',
        '/vendor/illuminate/contracts/Auth/StatefulGuard.php',
        '/vendor/illuminate/contracts/Auth/Access/Gate.php',
        '/vendor/illuminate/contracts/Hashing/Hasher.php',
        '/vendor/illuminate/auth/AuthManager.php',
        '/vendor/illuminate/auth/SessionGuard.php',
        '/vendor/illuminate/auth/Access/Gate.php',
        '/vendor/illuminate/contracts/Auth/UserProvider.php',
        '/vendor/illuminate/auth/EloquentUserProvider.php',
        '/vendor/illuminate/container/Container.php',
        '/vendor/symfony/http-kernel/HttpKernelInterface.php',
        '/vendor/symfony/http-kernel/TerminableInterface.php',
        '/src/Foundation/Application.php',
        '/src/Foundation/EnvironmentDetector.php',
        '/src/Foundation/Bootstrap/ConfigureLogging.php',
        '/src/Foundation/Bootstrap/HandleExceptions.php',
        '/src/Foundation/Bootstrap/RegisterFacades.php',
        '/src/Foundation/Bootstrap/RegisterProviders.php',
        '/src/Foundation/Bootstrap/BootProviders.php',
        '/src/Foundation/Bootstrap/LoadConfiguration.php',
        '/src/Foundation/Bootstrap/DetectEnvironment.php',
        '/src/Foundation/Http/Kernel.php',
        '/src/Foundation/Auth/AuthenticatesUsers.php',
        '/src/Foundation/Auth/RedirectsUsers.php',
        '/src/Foundation/Auth/RegistersUsers.php',
        '/src/Foundation/Auth/ResetsPasswords.php',
        '/vendor/illuminate/http/Request.php',
        '/vendor/illuminate/http/Middleware/FrameGuard.php',
        '/src/Foundation/Http/Middlewares/VerifyCsrfToken.php',
        '/src/Foundation/Http/Middlewares/CheckForMaintenanceMode.php',
        '/vendor/symfony/http-foundation/Request.php',
        '/vendor/symfony/http-foundation/ParameterBag.php',
        '/vendor/symfony/http-foundation/FileBag.php',
        '/vendor/symfony/http-foundation/ServerBag.php',
        '/vendor/symfony/http-foundation/HeaderBag.php',
        '/vendor/symfony/http-foundation/Session/SessionInterface.php',
        '/vendor/symfony/http-foundation/Session/SessionBagInterface.php',
        '/vendor/symfony/http-foundation/Session/Attribute/AttributeBagInterface.php',
        '/vendor/symfony/http-foundation/Session/Attribute/AttributeBag.php',
        '/vendor/symfony/http-foundation/Session/Storage/MetadataBag.php',
        '/vendor/symfony/http-foundation/AcceptHeaderItem.php',
        '/vendor/symfony/http-foundation/AcceptHeader.php',
        '/vendor/symfony/debug/ExceptionHandler.php',
        '/vendor/illuminate/support/ServiceProvider.php',
        '/vendor/illuminate/support/AggregateServiceProvider.php',
        '/vendor/illuminate/routing/RoutingServiceProvider.php',
        '/vendor/illuminate/events/EventServiceProvider.php',
        '/vendor/illuminate/validation/ValidationServiceProvider.php',
        '/src/Foundation/Validation/ValidatesRequests.php',
        '/vendor/illuminate/validation/ValidatesWhenResolvedTrait.php',
        '/src/Foundation/Auth/Access/AuthorizesRequests.php',
        '/src/Foundation/Http/FormRequest.php',
        '/src/Foundation/Bus/DispatchesJobs.php',
        '/vendor/illuminate/auth/AuthServiceProvider.php',
        '/vendor/illuminate/pagination/PaginationServiceProvider.php',
        '/vendor/illuminate/hashing/HashServiceProvider.php',
        '/vendor/illuminate/hashing/BcryptHasher.php',
        '/vendor/illuminate/contracts/Pagination/Paginator.php',
        '/vendor/illuminate/pagination/AbstractPaginator.php',
        '/vendor/illuminate/pagination/Paginator.php',
        '/vendor/illuminate/support/Facades/Facade.php',
        '/vendor/illuminate/support/Traits/Macroable.php',
        '/vendor/illuminate/support/Arr.php',
        '/vendor/illuminate/support/Str.php',
        '/vendor/symfony/debug/ErrorHandler.php',
        '/vendor/illuminate/config/Repository.php',
        '/vendor/illuminate/support/NamespacedItemResolver.php',
        '/vendor/illuminate/filesystem/Filesystem.php',
        '/src/Foundation/AliasLoader.php',
        '/src/Foundation/ProviderRepository.php',
        '/vendor/illuminate/cookie/CookieServiceProvider.php',
        '/vendor/illuminate/database/DatabaseServiceProvider.php',
        '/vendor/illuminate/encryption/EncryptionServiceProvider.php',
        '/vendor/illuminate/filesystem/FilesystemServiceProvider.php',
        '/vendor/illuminate/session/SessionServiceProvider.php',
        '/vendor/illuminate/view/ViewServiceProvider.php',
        '/vendor/illuminate/routing/RouteDependencyResolverTrait.php',
        '/vendor/illuminate/routing/Router.php',
        '/vendor/illuminate/routing/Route.php',
        '/vendor/illuminate/routing/RouteCollection.php',
        '/vendor/symfony/routing/CompiledRoute.php',
        '/vendor/symfony/routing/RouteCompilerInterface.php',
        '/vendor/symfony/routing/RouteCompiler.php',
        '/vendor/symfony/routing/Route.php',
        '/vendor/illuminate/routing/Controller.php',
        '/vendor/illuminate/routing/ControllerDispatcher.php',
        '/vendor/illuminate/routing/UrlGenerator.php',
        '/vendor/illuminate/bus/Dispatcher.php',
        '/vendor/illuminate/pipeline/Pipeline.php',
        '/vendor/illuminate/routing/Matching/ValidatorInterface.php',
        '/vendor/illuminate/routing/Matching/HostValidator.php',
        '/vendor/illuminate/routing/Matching/MethodValidator.php',
        '/vendor/illuminate/routing/Matching/SchemeValidator.php',
        '/vendor/illuminate/routing/Matching/UriValidator.php',
        '/vendor/illuminate/routing/Middleware/SubstituteBindings.php',
        '/vendor/illuminate/events/Dispatcher.php',
        '/vendor/illuminate/database/Eloquent/Model.php',
        '/vendor/illuminate/database/DatabaseManager.php',
        '/vendor/illuminate/database/ConnectionResolverInterface.php',
        '/vendor/illuminate/database/Connectors/ConnectionFactory.php',
        '/vendor/illuminate/session/SessionInterface.php',
        '/vendor/illuminate/session/Middleware/StartSession.php',
        '/vendor/illuminate/session/Store.php',
        '/vendor/illuminate/session/SessionManager.php',
        '/vendor/illuminate/support/Manager.php',
        '/vendor/illuminate/support/Collection.php',
        '/vendor/illuminate/cookie/CookieJar.php',
        '/vendor/illuminate/cookie/Middleware/EncryptCookies.php',
        '/vendor/illuminate/cookie/Middleware/AddQueuedCookiesToResponse.php',
        '/vendor/illuminate/encryption/Encrypter.php',
        '/vendor/illuminate/support/Facades/Log.php',
        '/vendor/illuminate/log/Writer.php',
        '/vendor/illuminate/view/Middleware/ShareErrorsFromSession.php',
        '/vendor/monolog/monolog/src/Monolog/Logger.php',
        '/vendor/psr/log/Psr/Log/LoggerInterface.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/AbstractHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/AbstractProcessingHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/RotatingFileHandler.php',
        '/vendor/monolog/monolog/src/Monolog/Handler/HandlerInterface.php',
        '/vendor/monolog/monolog/src/Monolog/Formatter/FormatterInterface.php',
        '/vendor/monolog/monolog/src/Monolog/Formatter/NormalizerFormatter.php',
        '/vendor/monolog/monolog/src/Monolog/Formatter/LineFormatter.php',
        '/vendor/illuminate/support/Facades/App.php',
        '/vendor/illuminate/support/Facades/Route.php',
        '/vendor/illuminate/view/Engines/EngineResolver.php',
        '/vendor/illuminate/view/ViewFinderInterface.php',
        '/vendor/illuminate/view/FileViewFinder.php',
        '/vendor/illuminate/view/Factory.php',
        '/vendor/illuminate/support/ViewErrorBag.php',
        '/vendor/illuminate/support/MessageBag.php',
        '/vendor/illuminate/support/Facades/View.php',
        '/vendor/illuminate/view/View.php',
        '/vendor/illuminate/view/Engines/EngineInterface.php',
        '/vendor/illuminate/view/Engines/PhpEngine.php',
        '/vendor/illuminate/view/Engines/CompilerEngine.php',
        '/vendor/illuminate/view/Compilers/CompilerInterface.php',
        '/vendor/illuminate/view/Compilers/Compiler.php',
        '/vendor/illuminate/view/Compilers/BladeCompiler.php',
        '/vendor/symfony/http-foundation/Response.php',
        '/vendor/illuminate/http/ResponseTrait.php',
        '/vendor/illuminate/http/Response.php',
        '/vendor/symfony/http-foundation/ResponseHeaderBag.php',
        '/vendor/symfony/http-foundation/Cookie.php',
        '/vendor/symfony/finder/SplFileInfo.php',
        '/vendor/symfony/finder/Iterator/FilterIterator.php',
        '/vendor/symfony/finder/Iterator/MultiplePcreFilterIterator.php',
        '/vendor/symfony/finder/Iterator/PathFilterIterator.php',
        '/vendor/symfony/finder/Iterator/ExcludeDirectoryFilterIterator.php',
        '/vendor/symfony/finder/Iterator/RecursiveDirectoryIterator.php',
        '/vendor/symfony/finder/Iterator/FileTypeFilterIterator.php',
        '/vendor/symfony/finder/Iterator/FilenameFilterIterator.php',
        '/vendor/symfony/finder/Finder.php',
        '/vendor/symfony/finder/Glob.php',
        '/vendor/vlucas/phpdotenv/src/Dotenv.php',
        '/vendor/nesbot/carbon/src/Carbon/Carbon.php',
    ];

    /**
     * @var string
     */
    protected $name = 'optimize';

    /**
     * @var string
     */
    protected $description = 'Optimize the framework for better performance';

    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * OptimizeCommand constructor.
     *
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();
        $this->composer = $composer;
    }

    /**
     * TODO: Method fire Description
     */
    public function fire()
    {
        $this->info('Generating optimized class loader');
        if ($this->option('psr')) {
            $this->composer->dumpAutoloads();
        } else {
            $this->composer->dumpOptimized();
        }
        if ($this->option('force') || !$this->laravel['config']['app.debug']) {
            $this->info('Compiling common classes');
            $this->compileClasses();
            $this->info('Compiled common classes');
        } else {
            $this->call('clear-compiled');
        }
    }

    /**
     * TODO: Method compileClasses Description
     */
    protected function compileClasses()
    {
        $preloader = (new Factory())->create(['skip' => true]);
        $handle = $preloader->prepareOutput($this->laravel->getCachedCompilePath());
        foreach ($this->getClassFiles() as $file) {
            try {
                fwrite($handle, $preloader->getCode($file, false) . "\n");
            } catch (VisitorExceptionInterface $e) {
            }
        }
        fclose($handle);
    }

    /**
     * TODO: Method getClassFiles Description
     *
     * @return array
     */
    protected function getClassFiles()
    {
        $core = collect($this->complies)->transform(function ($value) {
            return $this->laravel->basePath() . $value;
        })->toArray();
        $files = array_merge($core, $this->laravel['config']->get('compile.files', []));
        foreach ($this->laravel['config']->get('compile.providers', []) as $provider) {
            $files = array_merge($files, forward_static_call([
                $provider,
                'compiles',
            ]));
        }

        return array_map('realpath', $files);
    }

    /**
     * TODO: Method getOptions Description
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force the compiled class file to be written.',
            ],
            [
                'psr',
                null,
                InputOption::VALUE_NONE,
                'Do not optimize Composer dump-autoload.',
            ],
        ];
    }
}
