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
 * Class Authorizable.
 */
trait Authorizable
{
    /**
     * TODO: Method can Description
     *
     * @param       $ability
     * @param array $arguments
     *
     * @return bool
     */
    public function can($ability, $arguments = [])
    {
        return app(Gate::class)->forUser($this)->check($ability, $arguments);
    }

    /**
     * TODO: Method cant Description
     *
     * @param       $ability
     * @param array $arguments
     *
     * @return bool
     */
    public function cant($ability, $arguments = [])
    {
        return !$this->can($ability, $arguments);
    }

    /**
     * TODO: Method cannot Description
     *
     * @param       $ability
     * @param array $arguments
     *
     * @return bool
     */
    public function cannot($ability, $arguments = [])
    {
        return $this->cant($ability, $arguments);
    }
}
