<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 17:10
 */
namespace Notadd\Foundation\Composer\Abstracts;
use Composer\Factory;
use Composer\IO\ConsoleIO;
use Notadd\Foundation\Console\Abstracts\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Class Command
 * @package Notadd\Foundation\Composer\Abstracts
 */
abstract class Command extends AbstractCommand {
    /**
     * @var \Composer\Composer
     */
    protected $composer;
    /**
     * @var bool
     */
    protected $disablePluginsByDefault = false;
    /**
     * @var \Composer\IO\ConsoleIO
     */
    protected $io;
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
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $this->input = $input;
        $this->output = $output;
        $this->io = new ConsoleIO($input, $output, $this->getHelperSet());
        $this->composer = Factory::create($this->io, null, $this->disablePluginsByDefault);
        return $this->fire();
    }
}