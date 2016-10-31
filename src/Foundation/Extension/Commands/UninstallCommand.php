<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 19:15
 */
namespace Notadd\Foundation\Extension\Commands;
use Notadd\Foundation\Composer\Abstracts\Command;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class UninstallCommand
 * @package Notadd\Foundation\Extension\Commands
 */
class UninstallCommand extends Command {
    /**
     * @return void
     */
    public function configure() {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be uninstall');
        $this->setDescription('Uninstall a extension by name');
        $this->setName('extension:uninstall');
    }
    /**
     * @return true
     */
    public function fire() {
        return true;
    }
}