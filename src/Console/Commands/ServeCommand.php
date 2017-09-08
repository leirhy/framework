<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 12:21
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;

/**
 * Class ServeCommand.
 */
class ServeCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'serve';

    /**
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * Command handler.
     */
    public function handle()
    {
        chdir($this->laravel->publicPath());
        $host = $this->input->getOption('host');
        $port = $this->input->getOption('port');
        $base = ProcessUtils::escapeArgument($this->laravel->basePath());
        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder())->find(false));
        $this->info("Laravel development server started on http://{$host}:{$port}/");
        passthru("{$binary} -S {$host}:{$port} {$base}/server.php");
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
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'The host address to serve the application on.',
                'localhost',
            ],
            [
                'port',
                null,
                InputOption::VALUE_OPTIONAL,
                'The port to serve the application on.',
                8000,
            ],
        ];
    }
}
