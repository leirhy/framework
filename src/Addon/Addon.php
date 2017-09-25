<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Foundation\Addon;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Notadd\Foundation\Http\Traits\HasAttributes;

/**
 * Class Extension.
 */
class Addon implements Arrayable, ArrayAccess, JsonSerializable
{
    use HasAttributes;

    /**
     * Extension constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $offset
     * @param null   $default
     *
     * @return null
     */
    public function get(string $offset, $default = null)
    {
        return data_get($this->attributes, $offset, $default);
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
    public function enabled()
    {
        return boolval($this->attributes['enabled']);
    }

    /**
     * @return bool
     */
    public function installed()
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
//            && $this->offsetExists('description')
            && $this->offsetExists('author');
    }
}
