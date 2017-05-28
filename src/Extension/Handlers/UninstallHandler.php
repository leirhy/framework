<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-02 16:10
 */
namespace Notadd\Foundation\Extension\Handlers;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Notadd\Foundation\Extension\Abstracts\Uninstaller;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class UninstallHandler.
 */
class UninstallHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;

    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * UninstallHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Extension\ExtensionManager           $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Container $container, ExtensionManager $manager, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->manager = $manager;
        $this->settings = $settings;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $extension = $this->manager->get($this->request->input('identification'));
        if ($extension && method_exists($provider = $extension->getEntry(), 'uninstall') && $closure = call_user_func([
                $provider,
                'uninstall',
            ])
        ) {
            if ($closure instanceof Closure) {
                if (!$this->settings->get('extension.' . $extension->getIdentification() . '.installed', false)) {
                    $this->errors->push("模块[{$extension->getIdentification()}]尚未安装，无法进行卸载！");

                    return false;
                }

                if ($closure()) {
                    $output = new BufferedOutput();

                    $provider = $extension->getEntry();
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
                    $this->container->make('log')->info('uninstall extension:' . $extension->getIdentification(), $log);
                    $this->data = $log;
                    $this->settings->set('extension.' . $extension->getIdentification() . '.installed', false);
                    $this->messages->push('卸载插件[' . $extension->getIdentification() . ']成功！');

                    return true;
                }
            }
        }

        return false;
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
}
