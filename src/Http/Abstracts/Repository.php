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
use Illuminate\Filesystem\Filesystem;
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
     * @return \Illuminate\Container\Container
     */
    public function container()
    {
        return Container::getInstance();
    }

    /**
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function file()
    {
        return Container::getInstance()->make(Filesystem::class);
    }

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
