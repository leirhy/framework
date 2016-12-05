<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:05
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Finder\Finder;

/**
 * Class AppNameCommand.
 */
class AppNameCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'app:name';

    /**
     * @var string
     */
    protected $description = 'Set the application namespace';

    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $currentRoot;

    /**
     * AppNameCommand constructor.
     *
     * @param \Illuminate\Support\Composer      $composer
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Composer $composer, Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * @return void
     */
    public function fire()
    {
        $this->currentRoot = trim($this->laravel->getNamespace(), '\\');
        $this->setBootstrapNamespaces();
        $this->setAppDirectoryNamespace();
        $this->setConfigNamespaces();
        $this->setComposerNamespace();
        $this->setDatabaseFactoryNamespaces();
        $this->info('Application namespace set!');
        $this->composer->dumpAutoloads();
        $this->call('clear-compiled');
    }

    /**
     * @return void
     */
    protected function setAppDirectoryNamespace()
    {
        $files = Finder::create()->in($this->laravel['path'])->contains($this->currentRoot)->name('*.php');
        foreach ($files as $file) {
            $this->replaceNamespace($file->getRealPath());
        }
    }

    /**
     * @param string $path
     *
     * @return void
     */
    protected function replaceNamespace($path)
    {
        $search = [
            'namespace ' . $this->currentRoot . ';',
            $this->currentRoot . '\\',
        ];
        $replace = [
            'namespace ' . $this->argument('name') . ';',
            $this->argument('name') . '\\',
        ];
        $this->replaceIn($path, $search, $replace);
    }

    /**
     * @return void
     */
    protected function setBootstrapNamespaces()
    {
        $search = [
            $this->currentRoot . '\\Http',
            $this->currentRoot . '\\Console',
            $this->currentRoot . '\\Exceptions',
        ];
        $replace = [
            $this->argument('name') . '\\Http',
            $this->argument('name') . '\\Console',
            $this->argument('name') . '\\Exceptions',
        ];
        $this->replaceIn($this->getBootstrapPath(), $search, $replace);
    }

    /**
     * @return void
     */
    protected function setComposerNamespace()
    {
        $this->replaceIn($this->getComposerPath(), str_replace('\\', '\\\\', $this->currentRoot) . '\\\\',
            str_replace('\\', '\\\\', $this->argument('name')) . '\\\\');
    }

    /**
     * @return void
     */
    protected function setConfigNamespaces()
    {
        $this->setAppConfigNamespaces();
        $this->setAuthConfigNamespace();
        $this->setServicesConfigNamespace();
    }

    /**
     * @return void
     */
    protected function setAppConfigNamespaces()
    {
        $search = [
            $this->currentRoot . '\\Providers',
            $this->currentRoot . '\\Http\\Controllers\\',
        ];
        $replace = [
            $this->argument('name') . '\\Providers',
            $this->argument('name') . '\\Http\\Controllers\\',
        ];
        $this->replaceIn($this->getConfigPath('app'), $search, $replace);
    }

    /**
     * @return void
     */
    protected function setAuthConfigNamespace()
    {
        $this->replaceIn($this->getConfigPath('auth'), $this->currentRoot . '\\User',
            $this->argument('name') . '\\User');
    }

    /**
     * @return void
     */
    protected function setServicesConfigNamespace()
    {
        $this->replaceIn($this->getConfigPath('services'), $this->currentRoot . '\\User',
            $this->argument('name') . '\\User');
    }

    /**
     * @return void
     */
    protected function setDatabaseFactoryNamespaces()
    {
        $this->replaceIn($this->laravel->databasePath() . '/factories/ModelFactory.php', $this->currentRoot,
            $this->argument('name'));
    }

    /**
     * @param string       $path
     * @param string|array $search
     * @param string|array $replace
     *
     * @return void
     */
    protected function replaceIn($path, $search, $replace)
    {
        $this->files->put($path, str_replace($search, $replace, $this->files->get($path)));
    }

    /**
     * @return string
     */
    protected function getBootstrapPath()
    {
        return $this->laravel->bootstrapPath() . '/app.php';
    }

    /**
     * @return string
     */
    protected function getComposerPath()
    {
        return $this->laravel->basePath() . '/composer.json';
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getConfigPath($name)
    {
        return $this->laravel['path.config'] . '/' . $name . '.php';
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The desired namespace.',
            ],
        ];
    }
}
