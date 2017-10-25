<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 11:04
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Routing\Traits\Helpers;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class LoadConfiguration.
 */
class LoadConfiguration implements Bootstrap
{
    use Helpers;

    /**
     * Bootstrap the given application.
     */
    public function bootstrap()
    {
        $items = [];
        if (file_exists($cached = $this->container->getCachedConfigPath())) {
            $items = require_once $cached;
            $loadedFromCache = true;
        }
        $this->container->instance('config', $configuration = new Repository($items));
        if (!isset($loadedFromCache)) {
            $this->loadConfigurationFiles($this->container, $configuration);
        }
        mb_internal_encoding('UTF-8');
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     * @param \Illuminate\Contracts\Config\Repository                                     $repository
     *
     * @throws \Exception
     */
    protected function loadConfigurationFiles(Application $application, RepositoryContract $repository)
    {
        $files = $this->getConfigurationFiles($application);
        if (!isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }
        foreach ($this->getConfigurationFiles($application) as $key => $path) {
            $values = Yaml::parse(file_get_contents($path));
            $values = is_array($values) ? $values : [];
            array_walk_recursive($values, [$this, 'parseValues']);
            $repository->set($key, $values);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     *
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];
        $configPath = realpath($app->configPath());
        foreach (Finder::create()->files()->name('*.yaml')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);
            $files[$directory . basename($file->getRealPath(), '.yaml')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param \SplFileInfo $file
     * @param string       $configPath
     *
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();
        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested) . '.';
        }

        return $nested;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    protected function parseValues(&$value)
    {
        if (!is_string($value)) {
            return true;
        }
        preg_match_all('/%([a-zA-Z_]+)(?::(.*))?%/', $value, $matches);
        if (empty(array_shift($matches))) {
            return true;
        }
        $function = current(array_shift($matches));
        if (!function_exists($function)) {
            return true;
        }
        $args = current(array_shift($matches));
        $value = call_user_func_array($function, explode(',', $args));

        return true;
    }
}
