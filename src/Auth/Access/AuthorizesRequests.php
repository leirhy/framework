<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:48
 */
namespace Notadd\Foundation\Auth\Access;

use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Class AuthorizesRequests.
 */
trait AuthorizesRequests
{
    /**
     * TODO: Method authorize Description
     *
     * @param       $ability
     * @param array $arguments
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return mixed
     */
    public function authorize($ability, $arguments = [])
    {
        list($ability, $arguments) = $this->parseAbilityAndArguments($ability, $arguments);

        return app(Gate::class)->authorize($ability, $arguments);
    }

    /**
     * TODO: Method authorizeForUser Description
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|mixed $user
     * @param mixed                                            $ability
     * @param mixed|array                                      $arguments
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function authorizeForUser($user, $ability, $arguments = [])
    {
        list($ability, $arguments) = $this->parseAbilityAndArguments($ability, $arguments);

        return app(Gate::class)->forUser($user)->authorize($ability, $arguments);
    }

    /**
     * TODO: Method parseAbilityAndArguments Description
     *
     * @param mixed       $ability
     * @param mixed|array $arguments
     *
     * @return array
     */
    protected function parseAbilityAndArguments($ability, $arguments)
    {
        if (is_string($ability)) {
            return [
                $ability,
                $arguments,
            ];
        }
        $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];

        return [
            $this->normalizeGuessedAbilityName($method),
            $ability,
        ];
    }

    /**
     * TODO: Method normalizeGuessedAbilityName Description
     *
     * @param string $ability
     *
     * @return string
     */
    protected function normalizeGuessedAbilityName($ability)
    {
        $map = $this->resourceAbilityMap();

        return isset($map[$ability]) ? $map[$ability] : $ability;
    }

    /**
     * TODO: Method authorizeResource Description
     *
     * @param string                        $model
     * @param string|null                   $parameter
     * @param array                         $options
     * @param \Illuminate\Http\Request|null $request
     *
     * @return void
     */
    public function authorizeResource($model, $parameter = null, array $options = [], $request = null)
    {
        $parameter = $parameter ?: strtolower(class_basename($model));
        $middleware = [];
        foreach ($this->resourceAbilityMap() as $method => $ability) {
            $modelName = in_array($method, [
                'index',
                'create',
                'store',
            ]) ? $model : $parameter;
            $middleware["can:{$ability},{$modelName}"][] = $method;
        }
        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * TODO: Method resourceAbilityMap Description
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'show'    => 'view',
            'create'  => 'create',
            'store'   => 'create',
            'edit'    => 'update',
            'update'  => 'update',
            'destroy' => 'delete',
        ];
    }
}
