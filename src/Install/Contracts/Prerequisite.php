<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-27 17:01
 */
namespace Notadd\Install\Contracts;

/**
 * Interface PrerequisiteContract.
 */
interface Prerequisite
{
    /**
     * TODO: Method check Description
     *
     * @return mixed
     */
    public function check();

    /**
     * TODO: Method getErrors Description
     *
     * @return mixed
     */
    public function getErrors();
}
