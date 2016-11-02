<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 17:10
 */
namespace Notadd\Foundation\Composer\Abstracts;
use Composer\Config\JsonConfigSource;
use Composer\Factory;
use Composer\IO\ConsoleIO;
use Composer\Json\JsonFile;
use Exception;
use Notadd\Foundation\Console\Abstracts\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Class Command
 * @package Notadd\Foundation\Composer\Abstracts
 */
abstract class Command extends AbstractCommand {
    /**
     * @var mixed
     */
    protected $backup;
    /**
     * @var \Composer\Composer
     */
    protected $composer;
    /**
     * @var bool
     */
    protected $disablePluginsByDefault = false;
    /**
     * @var \Composer\Json\JsonFile
     */
    protected $file;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * @var \Composer\IO\ConsoleIO
     */
    protected $io;
    /**
     * @var \Composer\Config\JsonConfigSource
     */
    protected $json;
    /**
     * Command constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->file = new JsonFile($this->container->basePath() . DIRECTORY_SEPARATOR . 'composer.json');
        $this->files = $this->container->make('files');
        $this->backup = $this->file->read();
        $this->json = new JsonConfigSource($this->file);
    }
    /**
     * @param bool $optimize
     * @param bool $reload
     */
    protected function dumpAutoloads($optimize = true, $reload = false) {
        if($reload) {
            $this->composer = Factory::create($this->io, null, $this->disablePluginsByDefault);
        }
        $config = $this->composer->getConfig();
        $generator = $this->composer->getAutoloadGenerator();
        $installationManager = $this->composer->getInstallationManager();
        $localRepository = $this->composer->getRepositoryManager()->getLocalRepository();
        $package = $this->composer->getPackage();
        $generator->dump($config, $localRepository, $package, $installationManager, 'composer', $optimize);
        $this->info('Composer DumpAutoloads Completed!');
    }
    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return mixed
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $this->input = $input;
        $this->output = $output;
        $this->io = new ConsoleIO($input, $output, $this->getHelperSet());
        $this->composer = Factory::create($this->io, null, $this->disablePluginsByDefault);
        if(!method_exists($this, 'fire')) {
            throw new Exception('Method fire do not exits!', 404);
        }
        return $this->container->call([$this, 'fire']);
    }
}