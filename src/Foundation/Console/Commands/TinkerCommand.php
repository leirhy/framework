<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:23
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Psy\Configuration;
use Psy\Shell;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class TinkerCommand.
 */
class TinkerCommand extends Command
{
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
     * TODO: Method fire Description
     */
    public function fire()
    {
        $this->getApplication()->setCatchExceptions(false);
        $config = new Configuration();
        $config->getPresenter()->addCasters($this->getCasters());
        $shell = new Shell($config);
        $shell->addCommands($this->getCommands());
        $shell->setIncludes($this->argument('include'));
        $shell->run();
    }

    /**
     * TODO: Method getCommands Description
     *
     * @return array
     */
    protected function getCommands()
    {
        $commands = [];
        foreach ($this->getApplication()->all() as $name => $command) {
            if (in_array($name, $this->commandWhitelist)) {
                $commands[] = $command;
            }
        }

        return $commands;
    }

    /**
     * TODO: Method getCasters Description
     *
     * @return array
     */
    protected function getCasters()
    {
        return [
            'Notadd\Foundation\Application' => 'Notadd\Foundation\Console\IlluminateCaster::castApplication',
            'Illuminate\Support\Collection' => 'Notadd\Foundation\Console\IlluminateCaster::castCollection',
            'Illuminate\Database\Eloquent\Model' => 'Notadd\Foundation\Console\IlluminateCaster::castModel',
        ];
    }

    /**
     * TODO: Method getArguments Description
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'include',
                InputArgument::IS_ARRAY,
                'Include file(s) before starting tinker',
            ],
        ];
    }
}
