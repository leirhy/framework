<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:23
 */
namespace Notadd\Foundation\Console;
use Psy\Shell;
use Psy\Configuration;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class TinkerCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class TinkerCommand extends Command {
    /**
     * @var array
     */
    protected $commandWhitelist = [
        'clear-compiled',
        'down',
        'env',
        'inspire',
        'migrate',
        'optimize',
        'up',
    ];
    /**
     * @var string
     */
    protected $name = 'tinker';
    /**
     * @var string
     */
    protected $description = 'Interact with your application';
    /**
     * @return void
     */
    public function fire() {
        $this->getApplication()->setCatchExceptions(false);
        $config = new Configuration;
        $config->getPresenter()->addCasters($this->getCasters());
        $shell = new Shell($config);
        $shell->addCommands($this->getCommands());
        $shell->setIncludes($this->argument('include'));
        $shell->run();
    }
    /**
     * @return array
     */
    protected function getCommands() {
        $commands = [];
        foreach($this->getApplication()->all() as $name => $command) {
            if(in_array($name, $this->commandWhitelist)) {
                $commands[] = $command;
            }
        }
        return $commands;
    }
    /**
     * @return array
     */
    protected function getCasters() {
        return [
            'Illuminate\Foundation\Application' => 'Illuminate\Foundation\Console\IlluminateCaster::castApplication',
            'Illuminate\Support\Collection' => 'Illuminate\Foundation\Console\IlluminateCaster::castCollection',
            'Illuminate\Database\Eloquent\Model' => 'Illuminate\Foundation\Console\IlluminateCaster::castModel',
        ];
    }
    /**
     * @return array
     */
    protected function getArguments() {
        return [
            [
                'include',
                InputArgument::IS_ARRAY,
                'Include file(s) before starting tinker'
            ],
        ];
    }
}