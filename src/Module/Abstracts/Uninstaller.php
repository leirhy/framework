<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Module\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Collection;
use Notadd\Foundation\Module\Module as BaseModule;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Foundation\Translation\Translator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class Uninstaller.
 */
abstract class Uninstaller
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $info;

    /**
     * @var \Notadd\Foundation\Module\Module
     */
    protected $module;

    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * @var \Notadd\Foundation\Translation\Translator
     */
    protected $translator;

    /**
     * Uninstaller constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->info = new Collection();
        $this->settings = $this->container->make(SettingsRepository::class);
        $this->translator = $this->container->make(Translator::class);
    }

    /**
     * Get console instance.
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getConsole()
    {
        $kernel = $this->container->make(Kernel::class);
        $kernel->bootstrap();

        return $kernel->getArtisan();
    }

    /**
     * @return mixed
     */
    abstract public function handle();

    /**
     * Return output info for installation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function info()
    {
        return $this->info;
    }

    /**
     * @param \Notadd\Foundation\Module\Module $module
     */
    public function setModule(BaseModule $module)
    {
        $this->module = $module;
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        if (!$this->settings->get('module.' . $this->module->getIdentification() . '.installed', false)) {
            $this->info->put('errors', "模块[{$this->module->getIdentification()}]尚未安装，无法进行卸载！");

            return false;
        }
        if ($this->handle()) {
            $output = new BufferedOutput();

            $provider = $this->module->getEntry();
            $this->container->getProvider($provider) || $this->container->register($provider);
            if (method_exists($provider, 'migrations')) {
                $migrations = call_user_func([$provider, 'migrations']);
                foreach ((array)$migrations as $migration) {
                    $migration = str_replace($this->container->basePath(), '', $migration);
                    $input = new ArrayInput([
                        '--path' => $migration,
                        '--force' => true,
                    ]);
                    $this->getConsole()->find('migrate:rollback')->run($input, $output);
                }
            }
            $input = new ArrayInput([
                '--force' => true,
            ]);
            $this->getConsole()->find('vendor:publish')->run($input, $output);
            $log = explode(PHP_EOL, $output->fetch());
            $this->container->make('log')->info('uninstall module:' . $this->module->getIdentification(), $log);
            $this->info->put('data', $log);
            $this->settings->set('module.' . $this->module->getIdentification() . '.installed', false);
            $this->info->put('messages', '卸载模块[' . $this->module->getIdentification() . ']成功！');
            return true;
        }

        return false;
    }
}