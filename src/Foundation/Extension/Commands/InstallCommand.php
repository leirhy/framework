<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 19:11
 */
namespace Notadd\Foundation\Extension\Commands;
use Composer\Config;
use Composer\Config\JsonConfigSource;
use Composer\Json\JsonFile;
use Illuminate\Support\Composer;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class InstallCommand
 * @package Notadd\Foundation\Extension\Commands
 */
class InstallCommand extends Command {
    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;
    /**
     * InstallCommand constructor.
     * @param \Illuminate\Support\Composer $composer
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(Composer $composer, ExtensionManager $manager) {
        parent::__construct();
        $this->composer = $composer;
        $this->manager = $manager;
    }
    /**
     * @return void
     */
    protected function configure() {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be install');
        $this->setDescription('Install a Extension');
        $this->setName('extension:install');
    }
    /**
     * @return bool
     */
    protected function fire() {
        $name = $this->input->getArgument('name');
        $extensions = $this->manager->getExtensions();
        if(!$extensions->offsetExists($name)) {
            $this->error("Extension {$name} do not exist!");
            return false;
        }
        $file = new JsonFile($this->container->basePath() . DIRECTORY_SEPARATOR . 'composer.json');
        dd(collect($file->read()));
        return true;
    }
}