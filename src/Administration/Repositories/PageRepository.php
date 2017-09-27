<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-27 13:57
 */
namespace Notadd\Foundation\Administration\Repositories;

use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class PageRepository.
 */
class PageRepository extends Repository
{
    /**
     * Initialize.
     */
    public function initialize()
    {
        $this->module->pages()->each(function ($definition) {
            $this->items[] = $definition;
        });
    }
}
