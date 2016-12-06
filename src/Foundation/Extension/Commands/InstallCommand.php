<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-28 19:11
 */
namespace Notadd\Foundation\Extension\Commands;

use Illuminate\Support\Composer;
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
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * InstallCommand constructor.
     *
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();
        $this->composer = $composer;
    }

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
        $this->postInstall($settings);
        $this->composer->dumpAutoloads();
        $this->resetOpcache();
        $settings->set("extension.{$this->name}.installed", true);
        $this->info("Extension {$this->name} is installed!");

        return true;
    }

    /**
     * Post Install handler.
     *
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function postInstall(SettingsRepository $settings)
    {
        $settings->set("extension.{$this->name}.info", json_encode($this->info));
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
