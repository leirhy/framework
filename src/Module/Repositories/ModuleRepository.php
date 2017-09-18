<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:36
 */
namespace Notadd\Foundation\Module\Repositories;

use Illuminate\Support\Collection;

/**
 * Class ModuleRepository.
 */
class ModuleRepository extends Collection
{
    /**
     * ModuleRepository constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }
}
