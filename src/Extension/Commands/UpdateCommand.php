<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-01 15:34
 */
namespace Notadd\Foundation\Extension\Commands;

use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Notadd\Foundation\Console\Abstracts\Command;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class UpdateCommand.
 */
class UpdateCommand extends Command
{
    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * UpdateCommand constructor.
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
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of a extension to be update');
        $this->setDescription('Update a extension by name');
        $this->setName('extension:update');
    }

    /**
     * Command Handler.
     *
     * @param \Notadd\Foundation\Extension\ExtensionManager           $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return bool
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
        if (!$this->container->make(SettingsRepository::class)->get('extension.' . $name . '.installed')) {
            $this->error("Extension {$name} does not installed!");

            return false;
        }
        $extension = $extensions->get($name);
        $path = $extension;
        if (Str::contains($path, $manager->getVendorPath())) {
            $this->error("Please update extension {$name} from composer command!");

            return false;
        }
        $this->info("Extension {$name} is updated!");

        return true;
    }
}
