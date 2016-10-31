<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-24 10:11
 */
namespace Notadd\Foundation\Setting;
use Notadd\Foundation\Setting\Contracts\SettingsRepository as SettingsRepositoryContract;
/**
 * Class MemoryCacheSettingsRepository
 * @package Notadd\Foundation\Setting
 */
class MemoryCacheSettingsRepository implements SettingsRepositoryContract {
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $inner;
    /**
     * @var bool
     */
    protected $isCached;
    /**
     * @var array
     */
    protected $cache = [];
    /**
     * MemoryCacheSettingsRepository constructor.
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $inner
     */
    public function __construct(SettingsRepositoryContract $inner) {
        $this->inner = $inner;
    }
    /**
     * @return array|mixed
     */
    public function all() {
        if(!$this->isCached) {
            $this->cache = $this->inner->all();
            $this->isCached = true;
        }
        return $this->cache;
    }
    /**
     * @param $key
     */
    public function delete($key) {
        unset($this->cache[$key]);
        $this->inner->delete($key);
    }
    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null) {
        if(array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        } else {
            return array_get($this->all(), $key, $default);
        }
    }
    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $this->cache[$key] = $value;
        $this->inner->set($key, $value);
    }
}