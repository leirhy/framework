<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 19:11
 */
namespace Notadd\Foundation\Extension\Commands;
use Composer\Config\JsonConfigSource;
use Composer\Json\JsonFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Notadd\Foundation\Composer\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class InstallCommand
 * @package Notadd\Foundation\Extension\Commands
 */
class InstallCommand extends Command {
    /**
     * @var mixed
     */
    protected $backup;
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;
    /**
     * @var \Composer\Json\JsonFile
     */
    protected $file;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * @var \Composer\Config\JsonConfigSource
     */
    protected $json;
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;
    /**
     * InstallCommand constructor.
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Filesystem $files, ExtensionManager $manager, SettingsRepository $settings) {
        parent::__construct();
        $this->files = $files;
        $this->file = new JsonFile($this->container->basePath() . DIRECTORY_SEPARATOR . 'composer.json');
        $this->backup = $this->file->read();
        $this->json = new JsonConfigSource($this->file);
        $this->manager = $manager;
        $this->settings = $settings;
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
        $extensions = $this->manager->getExtensionPaths();
        if(!$extensions->offsetExists($name)) {
            $this->error("Extension {$name} do not exist!");
            return false;
        }
        if($this->settings->get('extension.' . $name . '.installed')) {
            $this->error("Extension {$name} is installed!");
            return false;
        }
        $extension = $extensions->get($name);
        $path = $extension;
        if(Str::contains($path, $this->manager->getVendorPath())) {
            $this->error("Extension {$name} is installed!");
            return false;
        }
        $extensionFile = new JsonFile($path . DIRECTORY_SEPARATOR . 'composer.json');
        $extension = collect($extensionFile->read());
        if($extension->has('autoload')) {
            collect($extension->get('autoload'))->each(function($value, $key) use($path) {
                switch($key) {
                    case 'psr-4':
                        collect($value)->each(function($value, $key) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value));
                            $psr_4 = array_merge($this->backup['autoload']['psr-4'], [
                                $key => $path . '/'
                            ]);
                            $this->backup['autoload']['psr-4'] = $psr_4;
                            $this->json->addProperty('autoload', $this->backup['autoload']);
                        });
                        break;
                }
            });
        }
        $this->dumpAutoloads(true, true);
        $this->settings->set('extension.' . $name . '.installed', true);
        $this->info("Extension {$name} has been installed!");
        return true;
    }
}