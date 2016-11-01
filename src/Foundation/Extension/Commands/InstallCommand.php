<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 19:11
 */
namespace Notadd\Foundation\Extension\Commands;
use Composer\Json\JsonFile;
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
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;
    /**
     * InstallCommand constructor.
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(ExtensionManager $manager, SettingsRepository $settings) {
        parent::__construct();
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
                    case 'classmap':
                        collect($value)->each(function($value) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value)) . '/';
                            if(!in_array($path, $this->backup['autoload']['classmap'])) {
                                $this->backup['autoload']['classmap'][] = $path;
                            }
                        });
                        break;
                    case 'files':
                        collect($value)->each(function($value) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value));
                            if(!in_array($path, $this->backup['autoload']['files'])) {
                                $this->backup['autoload']['files'][] = $path;
                            }
                        });
                        break;
                    case 'psr-0':
                        collect($value)->each(function($value, $key) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value)) . '/';
                            $this->backup['autoload']['psr-0'][$key] = $path;
                        });
                        break;
                    case 'psr-4':
                        collect($value)->each(function($value, $key) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value)) . '/';
                            $this->backup['autoload']['psr-4'][$key] = $path;
                        });
                        break;
                }
            });
            $this->json->addProperty('autoload', $this->backup['autoload']);
        }
        $this->dumpAutoloads(true, true);
        $this->settings->set('extension.' . $name . '.installed', true);
        $this->info("Extension {$name} is installed!");
        return true;
    }
}