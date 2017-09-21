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
     * Repository constructor.
     *
     * @param mixed $items
     */
    public function __construct($items)
    {
        parent::__construct($items);
        $this->initialize();
    }

    /**
     * Initialize.
     */
    abstract protected function initialize();

    /**
     * @return \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected function setting()
    {
        return Container::getInstance()->make(SettingsRepository::class);
    }
}
