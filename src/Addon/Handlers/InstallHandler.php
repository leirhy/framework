<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-02 15:51
 */
namespace Notadd\Foundation\Addon\Handlers;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;
use Notadd\Foundation\Addon\AddonManager;
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
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * @var \Notadd\Foundation\Addon\AddonManager
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
     * @param \Illuminate\Filesystem\Filesystem                       $file
     * @param \Notadd\Foundation\Addon\AddonManager                   $manager
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Container $container, Filesystem $file, AddonManager $manager, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->file = $file;
        $this->manager = $manager;
        $this->setting = $settings;
    }

    /**
     * Execute Handler.
     */
    public function execute()
    {
        set_time_limit(0);
        $extension = $this->manager->get($this->request->input('identification'));
        $output = new BufferedOutput();
        $result = false;
        $this->beginTransaction();
        if ($extension) {
            $collection = collect();
            // Has Migration.
            $extension->offsetExists('migrations') && $collection->put('migrations', $extension->get('migrations'));
            // Has Publishes.
            $extension->offsetExists('publishes') && $collection->put('publishes', $extension->get('publishes'));
            if (method_exists($provider = $extension->provider(), 'install')
                && $closure = call_user_func([
                    $provider,
                    'install',
                ])) {
                if ($closure instanceof Closure && !$this->setting->get('extension.' . $extension->identification() . '.installed', false) && $closure()) {
                    if ($collection->count() && $collection->every(function ($instance, $key) use ($extension, $output) {
                            switch ($key) {
                                case 'migrations':
                                    if (is_array($instance) && collect($instance)->every(function ($path) use (
                                            $extension,
                                            $output
                                        ) {
                                            $path = $extension->get('directory') . DIRECTORY_SEPARATOR . $path;
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
                                case 'publishes':
                                    if (is_array($instance) && collect($instance)->every(function ($from, $to) use (
                                            $extension,
                                            $output
                                        ) {
                                            $from = $extension->get('directory') . DIRECTORY_SEPARATOR . $from;
                                            $to = $this->container->basePath() . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR . $to;
                                            if ($this->file->isFile($from)) {
                                                $this->publishFile($from, $to);
                                            } else if ($this->file->isDirectory($from)) {
                                                $this->publishDirectory($from, $to);
                                            }

                                            return true;
                                        })) {
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
            }
        }
        if ($result) {
            $this->container->make('log')->info('Install Extension ' . $this->request->input('identification') . ':',
                explode(PHP_EOL, $output->fetch()));
            $this->setting->set('extension.' . $extension->identification() . '.installed', true);
            $this->commitTransaction();
            $this->withCode(200)->withMessage('安装模块成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('安装模块失败！');
        }
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
     * Publish the file to the given path.
     *
     * @param string $from
     * @param string $to
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function publishFile($from, $to)
    {
        $this->createParentDirectory(dirname($to));
        $this->file->copy($from, $to);
    }

    /**
     * Create the directory to house the published files if needed.
     *
     * @param $directory
     */
    protected function createParentDirectory($directory)
    {
        if (!$this->file->isDirectory($directory)) {
            $this->file->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Publish the directory to the given directory.
     *
     * @param $from
     * @param $to
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function publishDirectory($from, $to)
    {
        $manager = new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to'   => new Flysystem(new LocalAdapter($to)),
        ]);
        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file') {
                $manager->put('to://' . $file['path'], $manager->read('from://' . $file['path']));
            }
        }
    }
}
