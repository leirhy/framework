<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-01 15:34
 */
namespace Notadd\Foundation\Extension\Commands;
use Composer\Json\JsonFile;
use Illuminate\Support\Str;
use Notadd\Foundation\Composer\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class UpdateCommand
 * @package Notadd\Foundation\Extension\Commands
 */
class UpdateCommand extends Command {
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
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be update');
        $this->setDescription('Update a extension by name');
        $this->setName('extension:update');
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
        if(!$this->container->make(SettingsRepository::class)->get('extension.' . $name . '.installed')) {
            $this->error("Extension {$name} does not installed!");
            return false;
        }
        $extension = $extensions->get($name);
        $path = $extension;
        if(Str::contains($path, $this->manager->getVendorPath())) {
            $this->error("Please update extension {$name} from composer command!");
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
        $this->info("Extension {$name} is updated!");
        return true;
    }
}