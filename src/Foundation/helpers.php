<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 20:40
 */
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Notadd\Foundation\SearchEngine\Optimization;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

if (!function_exists('abort')) {
    /**
     * @param int    $code
     * @param string $message
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    function abort($code, $message = '', array $headers = [])
    {
        app()->abort($code, $message, $headers);
    }
}
if (!function_exists('abort_if')) {
    /**
     * @param bool   $boolean
     * @param int    $code
     * @param string $message
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    function abort_if($boolean, $code, $message = '', array $headers = [])
    {
        if ($boolean) {
            abort($code, $message, $headers);
        }
    }
}
if (!function_exists('abort_unless')) {
    /**
     * @param bool   $boolean
     * @param int    $code
     * @param string $message
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    function abort_unless($boolean, $code, $message = '', array $headers = [])
    {
        if (!$boolean) {
            abort($code, $message, $headers);
        }
    }
}
if (!function_exists('action')) {
    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return string
     */
    function action($name, $parameters = [], $absolute = true)
    {
        return app('url')->action($name, $parameters, $absolute);
    }
}
if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param string $make
     * @param array  $parameters
     *
     * @return mixed|\Notadd\Foundation\Application
     */
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make, $parameters);
    }
}
if (!function_exists('app_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function app_path($path = '')
    {
        return app('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('asset')) {
    /**
     * @param string $path
     * @param bool   $secure
     *
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}
if (!function_exists('auth')) {
    /**
     * @param string|null $guard
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function auth($guard = null)
    {
        if (is_null($guard)) {
            return app(AuthFactory::class);
        } else {
            return app(AuthFactory::class)->guard($guard);
        }
    }
}
if (!function_exists('back')) {
    /**
     * @param int   $status
     * @param array $headers
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function back($status = 302, $headers = [])
    {
        return app('redirect')->back($status, $headers);
    }
}
if (!function_exists('base_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function base_path($path = '')
    {
        return app()->basePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('bcrypt')) {
    /**
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}
if (!function_exists('broadcast')) {
    /**
     * @param mixed|null $event
     *
     * @return \Illuminate\Broadcasting\PendingBroadcast|void
     */
    function broadcast($event = null)
    {
        return app(BroadcastFactory::class)->event($event);
    }
}
if (!function_exists('cache')) {
    /**
     * @param dynamic key|key,default|data,expiration|null
     *
     * @throws \Exception
     * @return mixed
     */
    function cache()
    {
        $arguments = func_get_args();
        if (empty($arguments)) {
            return app('cache');
        }
        if (is_string($arguments[0])) {
            return app('cache')->get($arguments[0], isset($arguments[1]) ? $arguments[1] : null);
        }
        if (is_array($arguments[0])) {
            if (!isset($arguments[1])) {
                throw new Exception('You must set an expiration time when putting to the cache.');
            }

            return app('cache')->put(key($arguments[0]), reset($arguments[0]), $arguments[1]);
        }
    }
}
if (!function_exists('config')) {
    /**
     * @param array|string $key
     * @param mixed        $default
     *
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }
        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}
if (!function_exists('config_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function config_path($path = '')
    {
        return app()->make('path.config') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('cookie')) {
    /**
     * @param string $name
     * @param string $value
     * @param int    $minutes
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httpOnly
     *
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    function cookie(
        $name = null,
        $value = null,
        $minutes = 0,
        $path = null,
        $domain = null,
        $secure = false,
        $httpOnly = true
    ) {
        $cookie = app(CookieFactory::class);
        if (is_null($name)) {
            return $cookie;
        }

        return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly);
    }
}
if (!function_exists('csrf_field')) {
    /**
     * @return \Illuminate\Support\HtmlString
     */
    function csrf_field()
    {
        return new HtmlString('<input type="hidden" name="_token" value="' . csrf_token() . '">');
    }
}
if (!function_exists('csrf_token')) {
    /**
     * @throws \RuntimeException
     * @return string
     */
    function csrf_token()
    {
        $session = app('session');
        if (isset($session)) {
            return $session->getToken();
        }
        throw new RuntimeException('Application session store not set.');
    }
}
if (!function_exists('database_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function database_path($path = '')
    {
        return app()->databasePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('decrypt')) {
    /**
     * @param string $value
     *
     * @return string
     */
    function decrypt($value)
    {
        return app('encrypter')->decrypt($value);
    }
}
if (!function_exists('dispatch')) {
    /**
     * @param mixed $job
     *
     * @return mixed
     */
    function dispatch($job)
    {
        return app(Dispatcher::class)->dispatch($job);
    }
}
if (!function_exists('elixir')) {
    /**
     * @param string $file
     * @param string $buildDirectory
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    function elixir($file, $buildDirectory = 'build')
    {
        static $manifest = [];
        static $manifestPath;
        if (empty($manifest) || $manifestPath !== $buildDirectory) {
            $path = public_path($buildDirectory . '/rev-manifest.json');
            if (file_exists($path)) {
                $manifest = json_decode(file_get_contents($path), true);
                $manifestPath = $buildDirectory;
            }
        }
        if (isset($manifest[$file])) {
            return '/' . trim($buildDirectory . '/' . $manifest[$file], '/');
        }
        $unversioned = public_path($file);
        if (file_exists($unversioned)) {
            return '/' . trim($file, '/');
        }
        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}
if (!function_exists('encrypt')) {
    /**
     * @param string $value
     *
     * @return string
     */
    function encrypt($value)
    {
        return app('encrypter')->encrypt($value);
    }
}
if (!function_exists('env')) {
    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return value($default);
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }
        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}
if (!function_exists('event')) {
    /**
     * @param array ...$args
     *
     * @return mixed
     */
    function event(...$args)
    {
        return app('events')->fire(...$args);
    }
}
if (!function_exists('factory')) {
    /**
     * @param dynamic class|class,name|class,amount|class,name,amount
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    function factory()
    {
        $factory = app(EloquentFactory::class);
        $arguments = func_get_args();
        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : 1);
        } elseif (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        } else {
            return $factory->of($arguments[0]);
        }
    }
}
if (!function_exists('info')) {
    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    function info($message, $context = [])
    {
        app('log')->info($message, $context);
    }
}
if (!function_exists('logger')) {
    /**
     * @param string $message
     * @param array  $context
     *
     * @return \Illuminate\Contracts\Logging\Log|null
     */
    function logger($message = null, array $context = [])
    {
        if (is_null($message)) {
            return app('log');
        }

        return app('log')->debug($message, $context);
    }
}
if (!function_exists('method_field')) {
    /**
     * @param string $method
     *
     * @return \Illuminate\Support\HtmlString
     */
    function method_field($method)
    {
        return new HtmlString('<input type="hidden" name="_method" value="' . $method . '">');
    }
}
if (!function_exists('old')) {
    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function old($key = null, $default = null)
    {
        return app('request')->old($key, $default);
    }
}
if (!function_exists('policy')) {
    /**
     * @param object|string $class
     *
     * @throws \InvalidArgumentException
     * @return mixed
     */
    function policy($class)
    {
        return app(Gate::class)->getPolicyFor($class);
    }
}
if (!function_exists('public_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function public_path($path = '')
    {
        return app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('redirect')) {
    /**
     * @param string|null $to
     * @param int         $status
     * @param array       $headers
     * @param bool        $secure
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = [], $secure = null)
    {
        if (is_null($to)) {
            return app('redirect');
        }

        return app('redirect')->to($to, $status, $headers, $secure);
    }
}
if (!function_exists('request')) {
    /**
     * @param array|string $key
     * @param mixed        $default
     *
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }
        if (is_array($key)) {
            return app('request')->only($key);
        }

        return app('request')->input($key, $default);
    }
}
if (!function_exists('resolve')) {
    /**
     * @param string $name
     * @param array  $parameters
     *
     * @return mixed
     */
    function resolve($name, $parameters = [])
    {
        return app($name, $parameters);
    }
}
if (!function_exists('resource_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function resource_path($path = '')
    {
        return app()->resourcePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('response')) {
    /**
     * @param string $content
     * @param int    $status
     * @param array  $headers
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $factory = app(ResponseFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}
if (!function_exists('route')) {
    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return string
     */
    function route($name, $parameters = [], $absolute = true)
    {
        return app('url')->route($name, $parameters, $absolute);
    }
}
if (!function_exists('secure_asset')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function secure_asset($path)
    {
        return asset($path, true);
    }
}
if (!function_exists('secure_url')) {
    /**
     * @param string $path
     * @param mixed  $parameters
     *
     * @return string
     */
    function secure_url($path, $parameters = [])
    {
        return url($path, $parameters, true);
    }
}
if (!function_exists('seo')) {
    /**
     * @param string $meta
     *
     * @return string
     */
    function seo($meta)
    {
        return app()->make(Optimization::class)->getData($meta);
    }
}
if (!function_exists('session')) {
    /**
     * @param array|string $key
     * @param mixed        $default
     *
     * @return mixed
     */
    function session($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('session');
        }
        if (is_array($key)) {
            return app('session')->put($key);
        }

        return app('session')->get($key, $default);
    }
}
if (!function_exists('setting')) {
    /**
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    function setting($key, $default = '')
    {
        return app()->make(SettingsRepository::class)->get($key, $default);
    }
}
if (!function_exists('storage_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function storage_path($path = '')
    {
        return app('path.storage') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if (!function_exists('trans')) {
    /**
     * @param string $id
     * @param array  $parameters
     * @param string $domain
     * @param string $locale
     *
     * @return \Symfony\Component\Translation\TranslatorInterface|string
     */
    function trans($id = null, $parameters = [], $domain = 'messages', $locale = null)
    {
        if (is_null($id)) {
            return app('translator');
        }

        return app('translator')->trans($id, $parameters, $domain, $locale);
    }
}
if (!function_exists('trans_choice')) {
    /**
     * @param string               $id
     * @param int|array|\Countable $number
     * @param array                $parameters
     * @param string               $domain
     * @param string               $locale
     *
     * @return string
     */
    function trans_choice($id, $number, array $parameters = [], $domain = 'messages', $locale = null)
    {
        return app('translator')->transChoice($id, $number, $parameters, $domain, $locale);
    }
}
if (!function_exists('url')) {
    /**
     * @param string $path
     * @param mixed  $parameters
     * @param bool   $secure
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function url($path = null, $parameters = [], $secure = null)
    {
        if (is_null($path)) {
            return app(UrlGenerator::class);
        }

        return app(UrlGenerator::class)->to($path, $parameters, $secure);
    }
}
if (!function_exists('validator')) {
    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $factory = app(ValidationFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}
if (!function_exists('view')) {
    /**
     * @param string $view
     * @param array  $data
     * @param array  $mergeData
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function view($view = null, $data = [], $mergeData = [])
    {
        $factory = app(ViewFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}
