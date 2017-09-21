<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:24
 */
namespace Notadd\Foundation\Module\Repositories;

use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class AssetsRepository.
 */
class AssetsRepository extends Repository
{
    /**
     * Initialize.
     */
    protected function initialize()
    {
        collect($this->items)->each(function ($items, $module) {
            unset($this->items[$module]);
        });
    }
}
