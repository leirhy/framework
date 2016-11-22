<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-24 10:08
 */
namespace Notadd\Foundation\Setting\Contracts;

/**
 * Interface SettingsRepository.
 */
interface SettingsRepository
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $keyLike
     */
    public function delete($keyLike);

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value);
}
