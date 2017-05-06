<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-03 18:38
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;

/**
 * Class Permission.
 */
class Permission
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Permission constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param array                           $attributes
     */
    public function __construct(Container $container, array $attributes = [])
    {
        $this->container = $container;
        $this->attributes = $attributes;
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public static function createFromAttributes(array $attributes)
    {
        return new static(Container::getInstance(), $attributes);
    }

    /**
     * @return string
     */
    public function default()
    {
        return $this->attributes['default'];
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->attributes['description'];
    }

    /**
     * @return string
     */
    public function key()
    {
        return $this->attributes['key'];
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->attributes['name'];
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->attributes['type'];
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public static function validate(array $attributes)
    {
        $needs = [
            'default',
            'description',
            'key',
            'name',
            'type',
        ];
        foreach ($needs as $need) {
            if (!isset($attributes[$need])) {
                return false;
            }
        }

        return true;
    }
}
