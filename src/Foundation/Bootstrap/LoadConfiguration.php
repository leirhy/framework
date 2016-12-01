<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:04
 */
namespace Notadd\Foundation\Bootstrap;

use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Configuration\Loaders\FileLoader;
use Notadd\Foundation\Configuration\Repository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class LoadConfiguration.
 */
class LoadConfiguration
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     *
     * @return void
     */
    public function bootstrap(Application $application)
    {
        $items = [];
        $loader = new FileLoader($application['files'], $application['path'] . DIRECTORY_SEPARATOR . 'configurations');
//        if (file_exists($cached = $application->getCachedConfigPath())) {
//            $items = require $cached;
//            $loadedFromCache = true;
//        }
        $application->instance('config', $config = new Repository($loader, $application['env']));
        dd($config);
        if (!isset($loadedFromCache)) {
            $this->loadConfigurationFiles($application, $config);
        }
        mb_internal_encoding('UTF-8');
    }

    /**
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     * @param \Illuminate\Contracts\Config\Repository                                     $repository
     *
     * @return void
     */
    protected function loadConfigurationFiles(Application $application, RepositoryContract $repository)
    {
        foreach ($this->getConfigurationFiles($application) as $key => $path) {
            $repository->set($key, require $path);
        }
        if ($application->isInstalled()) {
            $database = require $application->storagePath() . DIRECTORY_SEPARATOR . 'bootstraps' . DIRECTORY_SEPARATOR . 'replace.php';
            $repository->set('database', $database);
        }
    }

    /**
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     *
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];
        $configPath = realpath($app->configPath());
        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $nesting = $this->getConfigurationNesting($file, $configPath);
            $files[$nesting . basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * @param string                                $configPath
     *
     * @return string
     */
    protected function getConfigurationNesting(SplFileInfo $file, $configPath)
    {
        $directory = dirname($file->getRealPath());
        if ($tree = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree) . '.';
        }

        return $tree;
    }
}
