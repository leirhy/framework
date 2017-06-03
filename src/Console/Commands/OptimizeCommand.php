<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 12:16
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class OptimizeCommand.
 */
class OptimizeCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'optimize';

    /**
     * @var string
     */
    protected $description = 'Optimize the framework for better performance';

    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * OptimizeCommand constructor.
     *
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();
        $this->composer = $composer;
    }

    /**
     * Command handler.
     */
    public function fire()
    {
        $this->info('Generating optimized class loader');
        if ($this->option('psr')) {
            $this->composer->dumpAutoloads();
        } else {
            $this->composer->dumpOptimized();
        }
        $this->call('clear-compiled');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force the compiled class file to be written.',
            ],
            [
                'psr',
                null,
                InputOption::VALUE_NONE,
                'Do not optimize Composer dump-autoload.',
            ],
        ];
    }
}
