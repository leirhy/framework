<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-19 10:54
 */
namespace Notadd\Foundation\Extension\Repositories;

use Illuminate\Container\Container;
use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class ExpandRepository.
 */
class ExtensionRepository extends Repository
{
    /**
     * Initialize.
     */
    public function initialize()
    {
        $this->initialized = true;
    }
}
