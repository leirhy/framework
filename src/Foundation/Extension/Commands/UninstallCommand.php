<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 19:15
 */
namespace Notadd\Foundation\Extension\Commands;
use Composer\Json\JsonFile;
use Illuminate\Support\Str;
use Notadd\Foundation\Composer\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class UninstallCommand
 * @package Notadd\Foundation\Extension\Commands
 */
class UninstallCommand extends Command {
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;
    /**
     * InstallCommand constructor.
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(ExtensionManager $manager) {
        parent::__construct();
        $this->manager = $manager;
    }
    /**
     * @return void
     */
    public function configure() {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be uninstall');
        $this->setDescription('Uninstall a extension by name');
        $this->setName('extension:uninstall');
    }
    /**
     * @return true
     */
    public function fire() {
        $name = $this->input->getArgument('name');
        $extensions = $this->manager->getExtensionPaths();
        $settings = $this->container->make(SettingsRepository::class);
        if(!$extensions->offsetExists($name)) {
            $this->error("Extension {$name} do not exist!");
            return false;
        }
        if(!$settings->get('extension.' . $name . '.installed')) {
            $this->error("Extension {$name} does not installed!");
            return false;
        }
        $extension = $extensions->get($name);
        $path = $extension;
        if(Str::contains($path, $this->manager->getVendorPath())) {
            $this->error("Please remove extension {$name} from composer.json!");
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
                            if($key = array_search($path, $this->backup['autoload']['classmap'], true)) {
                                unset($this->backup['autoload']['classmap'][$key]);
                            }
                        });
                        break;
                    case 'files':
                        collect($value)->each(function($value) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value));
                            if($key = array_search($path, $this->backup['autoload']['files'], true)) {
                                unset($this->backup['autoload']['files'][$key]);
                            }
                        });
                        break;
                    case 'psr-0':
                        collect($value)->each(function($value, $key) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value)) . '/';
                            unset($this->backup['autoload']['psr-0'][$key]);
                        });
                        break;
                    case 'psr-4':
                        collect($value)->each(function($value, $key) use($path) {
                            $path = str_replace($this->container->basePath() . '/', '', realpath($path . DIRECTORY_SEPARATOR . $value)) . '/';
                            unset($this->backup['autoload']['psr-4'][$key]);
                        });
                        break;
                }
            });
            $this->json->addProperty('autoload', $this->backup['autoload']);
        }
        $this->dumpAutoloads(true, true);
        $settings->set('extension.' . $name . '.installed', false);
        $this->info("Extension {$name} is uninstalled!");
        return true;
    }
}