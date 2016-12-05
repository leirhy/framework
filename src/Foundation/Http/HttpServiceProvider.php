<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 10:52
 */
namespace Notadd\Foundation\Http;

use Application\Http\Listeners\RouteRegistrar;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HttpServiceProvider.
 */
class HttpServiceProvider extends ServiceProvider
{
    /**
     * TODO: Method boot Description
     */
    public function boot()
    {
        $this->app->make('events')->subscribe(RouteRegistrar::class);
        $this->configureFormRequests();
        $this->loadViewsFrom(resource_path('errors'), 'error');
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');
        $this->loadViewsFrom(resource_path('views/theme'), 'theme');
    }

    /**
     * TODO: Method configureFormRequests Description
     */
    protected function configureFormRequests()
    {
        $this->app->afterResolving(function (ValidatesWhenResolved $resolved) {
            $resolved->validate();
        });
        $this->app->resolving(function (FormRequest $request, $app) {
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
        });
    }

    /**
     * TODO: Method initializeRequest Description
     *
     * @param \Notadd\Foundation\Http\FormRequest       $form
     * @param \Symfony\Component\HttpFoundation\Request $current
     */
    protected function initializeRequest(FormRequest $form, Request $current)
    {
        $files = $current->files->all();
        $files = is_array($files) ? array_filter($files) : $files;
        $form->initialize($current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent());
        if ($session = $current->getSession()) {
            $form->setSession($session);
        }
        $form->setUserResolver($current->getUserResolver());
        $form->setRouteResolver($current->getRouteResolver());
    }
}
