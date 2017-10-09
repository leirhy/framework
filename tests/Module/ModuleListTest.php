<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-09 16:39
 */
namespace Notadd\Foundation\Tests\Module;

use Illuminate\Container\Container;
use Notadd\Foundation\Module\ModuleManager;
use PHPUnit\Framework\TestCase;

/**
 * Class ModuleListTest.
 */
class ModuleListTest extends TestCase
{
    public function testList()
    {
        $list = (new ModuleManager(Container::getInstance()))->repository();
        $this->assertNotEmpty($list->all());
    }
}
