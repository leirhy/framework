<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 19:11
 */
namespace Notadd\Foundation\Extension\Commands;

use Composer\Json\JsonFile;
use Illuminate\Support\Str;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class InstallCommand.
 */
class InstallCommand extends Command
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $extension;

    /**
     * @var array
     */
    protected $info = [];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be install');
        $this->setDescription('Install a Extension');
        $this->setName('extension:install');
    }

    /**
     * TODO: Method fire Description
     *
     * @param \Notadd\Foundation\Extension\ExtensionManager           $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return bool
     * @throws \Exception
     */
    public function fire(ExtensionManager $manager, SettingsRepository $settings)
    {
        $this->name = $this->input->getArgument('name');
        $extensions = $manager->getExtensionPaths();
        if (!$extensions->offsetExists($this->name)) {
            $this->error("Extension {$this->name} do not exist!");

            return false;
        }
        if ($settings->get("extension.{$this->name}.installed")) {
            $this->error("Extension {$this->name} is installed!");

            return false;
        }
        $this->path = $extensions->get($this->name);
        if (Str::contains($this->path, $manager->getVendorPath())) {
            $this->error("Extension {$this->name} is installed!");

            return false;
        }
        if (!$this->files->exists($bootstrap = $this->path . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
            $this->error('Extension files do not exists!');

            return false;
        }
        $extensionFile = new JsonFile($this->path . DIRECTORY_SEPARATOR . 'composer.json');
        $this->extension = collect($extensionFile->read());
        $this->preInstall();
        $this->updateComposer(true);
        $this->postInstall($settings);
        $this->resetOpcache();
        $settings->set("extension.{$this->name}.installed", true);
        $this->info("Extension {$this->name} is installed!");

        return true;
    }

    /**
     * TODO: Method postInstall Description
     *
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function postInstall(SettingsRepository $settings)
    {
        if ($this->extension->has('autoload')) {
            $this->json->addProperty('autoload', $this->backup['autoload']);
            $settings->set("extension.{$this->name}.autoload", json_encode($this->extension->get('autoload')));
        }
        if ($this->extension->has('require')) {
            $this->json->addProperty('require', $this->backup['require']);
            $settings->set("extension.{$this->name}.require", json_encode($this->extension->get('require')));
        }
        $settings->set("extension.{$this->name}.info", json_encode($this->info));
    }

    /**
     * TODO: Method preInstall Description
     */
    public function preInstall()
    {
        if ($this->extension->has('autoload')) {
            $autoload = collect($this->extension->get('autoload'));
            $autoload->has('classmap') && collect($autoload->get('classmap'))->each(function ($value) {
                $path = str_replace($this->container->basePath() . DIRECTORY_SEPARATOR, '',
                        realpath($this->path . DIRECTORY_SEPARATOR . $value)) . DIRECTORY_SEPARATOR;
                if (!in_array($path, $this->backup['autoload']['classmap'])) {
                    $this->backup['autoload']['classmap'][] = $path;
                }
            });
            $autoload->has('files') && collect($autoload->get('files'))->each(function ($value) {
                $path = str_replace($this->container->basePath() . DIRECTORY_SEPARATOR, '',
                    realpath($this->path . DIRECTORY_SEPARATOR . $value));
                $this->backup['autoload']['files'][] = $path;
            });
            $autoload->has('psr-0') && collect($autoload->get('psr-0'))->each(function ($value, $key) {
                $path = str_replace($this->container->basePath() . DIRECTORY_SEPARATOR, '',
                        realpath($this->path . DIRECTORY_SEPARATOR . $value)) . DIRECTORY_SEPARATOR;
                $this->backup['autoload']['psr-0'][$key] = $path;
            });
            $autoload->has('psr-4') && collect($autoload->get('psr-4'))->each(function ($value, $key) {
                $path = str_replace($this->container->basePath() . DIRECTORY_SEPARATOR, '',
                        realpath($this->path . DIRECTORY_SEPARATOR . $value)) . DIRECTORY_SEPARATOR;
                $this->backup['autoload']['psr-4'][$key] = $path;
            });
        }
        if ($this->extension->has('require')) {
            $require = collect($this->extension->get('require'));
            $require->each(function ($version, $name) {
                $this->backup['require'][$name] = $version;
            });
        }
    }

    /**
     * Zend OPCache reset.
     */
    public function resetOpcache()
    {
        if (function_exists('opcache_reset')) {
            call_user_func('opcache_reset');
        }
        if (function_exists('accelerator_reset')) {
            call_user_func('accelerator_reset');
        }
    }
}
