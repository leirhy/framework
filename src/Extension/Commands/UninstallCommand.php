<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 19:15
 */
namespace Notadd\Foundation\Extension\Commands;

use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class UninstallCommand.
 */
class UninstallCommand extends Command
{
    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * UninstallCommand constructor.
     *
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();
        $this->composer = $composer;
    }

    /**
     * Configure Command.
     */
    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be uninstall');
        $this->setDescription('Uninstall a extension by name');
        $this->setName('extension:uninstall');
    }

    /**
     * Command Handler.
     *
     * @param \Notadd\Foundation\Extension\ExtensionManager           $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return true
     * @throws \Exception
     */
    public function fire(ExtensionManager $manager, SettingsRepository $settings)
    {
        $name = $this->input->getArgument('name');
        $extensions = $manager->getExtensionPaths();
        if (!$extensions->offsetExists($name)) {
            $this->error("Extension {$name} do not exist!");

            return false;
        }
        if (!$settings->get('extension.' . $name . '.installed')) {
            $this->error("Extension {$name} does not installed!");

            return false;
        }
        $path = $extensions->get($name);
        if (Str::contains($path, $manager->getVendorPath())) {
            $this->error("Please remove extension {$name} from composer.json!");

            return false;
        }
        $this->composer->dumpAutoloads();
        $settings->set('extension.' . $name . '.installed', false);
        $this->info("Extension {$name} is uninstalled!");

        return true;
    }
}
