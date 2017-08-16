<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-13 21:06
 */
namespace Notadd\Foundation\Module;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Notadd\Foundation\Extension\Traits\HasAttributes;

/**
 * Class Module.
 */
class Module implements Arrayable, ArrayAccess, JsonSerializable
{
    use HasAttributes;

    /**
     * Module constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function identification()
    {
        return $this->attributes['identification'];
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return boolval($this->attributes['enabled']);
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        return boolval($this->attributes['installed']);
    }

    /**
     * @return string
     */
    public function provider()
    {
        return $this->attributes['provider'];
    }

    /**
     * @return array
     */
    public function scripts()
    {
        $data = collect();
        collect(data_get($this->attributes, 'assets.scripts'))->each(function ($script) use ($data) {
            $data->put($this->attributes['identification'], asset($script));
        });

        return $data->toArray();
    }

    /**
     * @return array
     */
    public function stylesheets()
    {
        $data = collect();
        collect(data_get($this->attributes, 'assets.stylesheets'))->each(function ($stylesheet) use ($data) {
            $data->put($this->attributes['identification'], asset($stylesheet));
        });

        return $data->toArray();
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return $this->offsetExists('name')
            && $this->offsetExists('identification')
            && $this->offsetExists('description')
            && $this->offsetExists('author');
    }
}
