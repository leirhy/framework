<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-10-05 22:10
 */
namespace Notadd\Foundation\Extension\Commands;

use Notadd\Foundation\Console\Abstracts\Command;

/**
 * Class InstallCommand.
 */
class InstallCommand extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setDescription('To install a extension by identification');
        $this->setName('extension:install');
    }

    /**
     * Command handler.
     *
     * @return bool
     */
    public function handle(): bool
    {
        return true;
    }
}