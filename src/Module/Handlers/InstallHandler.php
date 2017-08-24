<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-02 15:34
 */
namespace Notadd\Foundation\Module\Handlers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Collection;
use Notadd\Foundation\Module\Abstracts\Installer;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class InstallHandler.
 */
class InstallHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $setting;

    /**
     * InstallHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Module\ModuleManager                 $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $setting
     */
    public function __construct(Container $container, ModuleManager $manager, SettingsRepository $setting)
    {
        parent::__construct($container);
        $this->manager = $manager;
        $this->setting = $setting;
    }

    /**
     * Execute handler.
     */
    public function execute()
    {
        set_time_limit(0);
        $module = $this->manager->get($this->request->input('identification'));
        $output = new BufferedOutput();
        $result = false;
        if ($module) {
            $collection = collect();
            // Has Installer.
            $module->offsetExists('installer') && tap($collection, function (Collection $collection) use ($module) {
                if (class_exists($installer = $module->get('installer'))) {
                    $collection->put('installer', $this->container->make($installer));
                }
            });
            // Has Migration.
            $module->offsetExists('migrations') && $collection->put('migrations', $module->get('migrations'));
            // Query Collection.
            if ($collection->count() && $collection->every(function ($instance, $key) use ($module, $output) {
                    switch ($key) {
                        case 'migrations':
                            if (is_array($instance) && collect($instance)->every(function ($path) use ($module, $output) {
                                    $path = $module->get('directory') . DIRECTORY_SEPARATOR . $path;
                                    $migration = str_replace($this->container->basePath(), '', $path);
                                    $migration = trim($migration, DIRECTORY_SEPARATOR);
                                    $input = new ArrayInput([
                                        '--path'  => $migration,
                                        '--force' => true,
                                    ]);
                                    $this->getConsole()->find('migrate')->run($input, $output);

                                    return true;
                                })) {
                                return true;
                            } else {
                                return false;
                            }
                            break;
                        case 'uninstall':
                            if ($instance instanceof Installer && $instance->install()) {
                                return true;
                            } else {
                                return false;
                            }
                            break;
                        default:
                            return false;
                            break;
                    }
                })) {
                $result = true;
            }
        }
        if ($result) {
            $this->container->make('log')->info('Install Module ' . $this->request->input('identification') . ':', explode(PHP_EOL, $output->fetch()));
            $this->setting->set('module.' . $module->identification() . '.installed', true);
            $this->withCode(200)->withMessage('安装模块成功！');
        } else {
            $this->withCode(500)->withError('安装模块失败！');
        }
    }

    /**
     * Get console instance.
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getConsole()
    {
        $kernel = $this->container->make(Kernel::class);
        $kernel->bootstrap();

        return $kernel->getArtisan();
    }

    protected function parseInfo(Collection $data) {
        $data->has('data') && $this->data = collect($data->get('data'));
        $data->has('errors') && $this->errors = collect($data->get('errors'));
        $data->has('messages') && $this->messages = collect($data->get('messages'));
    }
}
