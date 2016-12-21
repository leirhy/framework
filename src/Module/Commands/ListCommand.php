<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-21 18:12
 */
namespace Notadd\Foundation\Module\Commands;

use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Module\ModuleManager;

/**
 * Class ListCommand.
 */
class ListCommand extends Command
{
    /**
     * @var array
     */
    protected $headers = [
        'Module Name',
        'Module Path',
        'Enabled',
    ];

    /**
     * Configure Command.
     */
    public function configure()
    {
        $this->setDescription('Show module list.');
        $this->setName('module:list');
    }

    /**
     * Command Handler.
     *
     * @param \Notadd\Foundation\Module\ModuleManager $manager
     */
    public function fire(ModuleManager $manager)
    {

    }
}