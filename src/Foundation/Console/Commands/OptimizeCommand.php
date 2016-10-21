<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:16
 */
namespace Notadd\Foundation\Console\Commands;
use ClassPreloader\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use ClassPreloader\Exceptions\VisitorExceptionInterface;
/**
 * Class OptimizeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class OptimizeCommand extends Command {
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
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Composer $composer) {
        parent::__construct();
        $this->composer = $composer;
    }
    /**
     * @return void
     */
    public function fire() {
        $this->info('Generating optimized class loader');
        if($this->option('psr')) {
            $this->composer->dumpAutoloads();
        } else {
            $this->composer->dumpOptimized();
        }
        if($this->option('force') || !$this->laravel['config']['app.debug']) {
            $this->info('Compiling common classes');
            $this->compileClasses();
        } else {
            $this->call('clear-compiled');
        }
    }
    /**
     * @return void
     */
    protected function compileClasses() {
        $preloader = (new Factory)->create(['skip' => true]);
        $handle = $preloader->prepareOutput($this->laravel->getCachedCompilePath());
        foreach($this->getClassFiles() as $file) {
            try {
                fwrite($handle, $preloader->getCode($file, false) . "\n");
            } catch(VisitorExceptionInterface $e) {
            }
        }
        fclose($handle);
    }
    /**
     * @return array
     */
    protected function getClassFiles() {
        $app = $this->laravel;
        $core = require __DIR__ . '/Optimize/config.php';
        $files = array_merge($core, $app['config']->get('compile.files', []));
        foreach($app['config']->get('compile.providers', []) as $provider) {
            $files = array_merge($files, forward_static_call([
                $provider,
                'compiles'
            ]));
        }
        return array_map('realpath', $files);
    }
    /**
     * @return array
     */
    protected function getOptions() {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force the compiled class file to be written.'
            ],
            [
                'psr',
                null,
                InputOption::VALUE_NONE,
                'Do not optimize Composer dump-autoload.'
            ],
        ];
    }
}