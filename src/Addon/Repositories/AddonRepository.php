<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:50
 */
namespace Notadd\Foundation\Addon\Repositories;

use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class ExtensionRepository.
 */
class AddonRepository extends Repository
{
    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * Initialize.
     */
    public function initialize()
    {
        if (!$this->initialized) {
            $this->initialized = true;
        }
    }
}
