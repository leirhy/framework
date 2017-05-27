<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-02 15:51
 */
namespace Notadd\Foundation\Extension\Handlers;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Notadd\Foundation\Extension\Abstracts\Installer;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class InstallHandler.
 */
class InstallHandler extends SetHandler
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
     * InstallHandler constructor.
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
        if ($extension && method_exists($provider = $extension->getEntry(), 'install') && $closure = call_user_func([
                $provider,
                'install',
            ])
        ) {
            if ($closure instanceof Closure) {
                if ($this->settings->get('extension.' . $extension->getIdentification() . '.installed', false)) {
                    $this->errors->push('模块标识[]已经被占用，如需继续安装，请卸载同标识插件！');

                    return false;
                }
                $this->container->getProvider($provider) || $this->container->register($provider);
                if ($closure()) {
                    $input = new ArrayInput([
                        '--force' => true,
                    ]);
                    $output = new BufferedOutput();
                    $this->getConsole()->find('migrate')->run($input, $output);
                    $this->getConsole()->find('vendor:publish')->run($input, $output);
                    $log = explode(PHP_EOL, $output->fetch());
                    $this->container->make('log')->info('install module:' . $extension->getIdentification(), $log);
                    $this->data = $log;
                    $this->messages->push('安装插件[' . $extension->getIdentification() . ']成功！');
                    $this->settings->set('extension.' . $extension->getIdentification() . '.installed', true);

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
