<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-21 14:26
 */
namespace Notadd\Foundation\Http\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class Repository.
 */
abstract class Repository extends Collection
{
    /**
     * Initialize.
     */
    abstract public function initialize();

    /**
     * @param string $key
     * @param string $default
     *
     * @return mixed|\Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected function setting($key = '', $default = '')
    {
        if ($key) {
            return Container::getInstance()->make(SettingsRepository::class)->get($key, $default);
        } else {
            return Container::getInstance()->make(SettingsRepository::class);
        }
    }
}
