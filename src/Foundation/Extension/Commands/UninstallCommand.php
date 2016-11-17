<?php
/**
 * This file is part of Notadd.
 *
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
 * Class UninstallCommand.
 */
class UninstallCommand extends Command
{
    /**
     * @return void
     */
    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be uninstall');
        $this->setDescription('Uninstall a extension by name');
        $this->setName('extension:uninstall');
    }

    /**
     * @param \Notadd\Foundation\Extension\ExtensionManager           $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return true
     */
    public function fire(ExtensionManager $manager, SettingsRepository $settings)
    {
        $name = $this->input->getArgument('name');
        $extensions = $manager->getExtensionPaths();
        if (!$extensions->offsetExists($name)) {
            $this->error("Extension {$name} do not exist!");

            return false;
        }
        if (!$settings->get('extension.'.$name.'.installed')) {
            $this->error("Extension {$name} does not installed!");

            return false;
        }
        $path = $extensions->get($name);
        if (Str::contains($path, $manager->getVendorPath())) {
            $this->error("Please remove extension {$name} from composer.json!");

            return false;
        }
        $extensionFile = new JsonFile($path.DIRECTORY_SEPARATOR.'composer.json');
        $autoload = collect(json_decode($settings->get('extension.'.$name.'.autoload'), true));
        if (!$autoload->isEmpty()) {
            $autoload->has('classmap') && collect($autoload->get('classmap'))->each(function ($value) use ($path) {
                $path = str_replace($this->container->basePath().'/', '', realpath($path.DIRECTORY_SEPARATOR.$value)).'/';
                if ($key = array_search($path, $this->backup['autoload']['classmap'], true)) {
                    unset($this->backup['autoload']['classmap'][$key]);
                }
            });
            $autoload->has('files') && collect($autoload->get('files'))->each(function ($value) use ($path) {
                $path = str_replace($this->container->basePath().'/', '', realpath($path.DIRECTORY_SEPARATOR.$value));
                if ($key = array_search($path, $this->backup['autoload']['files'], true)) {
                    unset($this->backup['autoload']['files'][$key]);
                }
            });
            $autoload->has('psr-0') && collect($autoload->get('psr-0'))->each(function ($value, $key) use ($path) {
                $path = str_replace($this->container->basePath().'/', '', realpath($path.DIRECTORY_SEPARATOR.$value)).'/';
                unset($this->backup['autoload']['psr-0'][$key]);
            });
            $autoload->has('psr-4') && collect($autoload->get('psr-4'))->each(function ($value, $key) use ($path) {
                $path = str_replace($this->container->basePath().'/', '', realpath($path.DIRECTORY_SEPARATOR.$value)).'/';
                unset($this->backup['autoload']['psr-4'][$key]);
            });
            $this->json->addProperty('autoload', $this->backup['autoload']);
            $settings->set('extension.'.$name.'.autoload', json_encode([]));
        }
        $require = collect(json_decode($settings->get('extension.'.$name.'.require'), true));
        if (!$require->isEmpty()) {
            $require->each(function ($version, $name) {
                unset($this->backup['require'][$name]);
            });
            $this->json->addProperty('require', $this->backup['require']);
            $settings->set('extension.'.$name.'.require', json_encode([]));
        }
        $settings->set('extension.'.$name.'.installed', false);
        $this->updateComposer(true);
        $this->info("Extension {$name} is uninstalled!");

        return true;
    }
}
