<?php

// +----------------------------------------------------------------------+
// | The Notadd Framework.                                              |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016-2017 Shanxi Benchu Network Technology Co,.Ltd     |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the Apache license,    |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.apache.org/licenses/LICENSE-2.0.html                      |
// +----------------------------------------------------------------------+
// | Author: TwilRoad <heshudong@ibenchu.com>                             |
// |         Seven Du <shiweidu@outlook.com>                              |
// +----------------------------------------------------------------------+

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
     * @return string
     */
    public function identification()
    {
        return $this->attributes['identification'];
    }

    /**
     * Get The addon enabled.
     *
     * @return bool
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function enabled(): bool
    {
        return (bool) $this->get('enabled', false);
    }

    /**
     * @return bool
     */
    public function installed()
    {
        return boolval($this->attributes['installed'] ?? false);
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
