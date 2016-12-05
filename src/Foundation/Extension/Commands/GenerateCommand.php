<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 19:18
 */
namespace Notadd\Foundation\Extension\Commands;

use Notadd\Foundation\Composer\Abstracts\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GenerateCommand.
 */
class GenerateCommand extends Command
{
    /**
     * @return void
     * TODO: Method configure Description
     */
    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be uninstall');
        $this->setDescription('Generate a extension by name');
        $this->setName('extension:generate');
    }

    /**
     * @return true
     * TODO: Method fire Description
     *
     */
    public function fire()
    {
        return true;
    }
}
