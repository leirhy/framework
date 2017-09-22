<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:36
 */
namespace Notadd\Foundation\Module\Repositories;

use Illuminate\Support\Collection;
use Notadd\Foundation\Http\Abstracts\Repository;
use Notadd\Foundation\Module\Module;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ModuleRepository.
 */
class ModuleRepository extends Repository
{
    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * Initialize.
     */
    public function initialize()
    {
        if (!$this->initialized) {
            collect($this->items)->each(function ($directory, $index) {
                unset($this->items[$index]);
                $module = new Module([
                    'directory' => $directory,
                ]);
                if ($this->file()->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                    $configurations = $this->loadConfigurations($directory);
                    $package = collect(json_decode($this->file()->get($file), true));
                    $configurations->isNotEmpty() && $configurations->each(function ($value, $item) use ($module) {
                        $module->offsetSet($item, $value);
                    });
                    if ($package->get('type') == 'notadd-module'
                        && $configurations->get('identification') == $package->get('name')
                        && $module->validate()) {
                        $autoload = collect([
                            $directory,
                            'vendor',
                            'autoload.php',
                        ])->implode(DIRECTORY_SEPARATOR);
                        $this->file()->exists($autoload) && $this->file()->requireOnce($autoload);
                        $module->offsetExists('service') || collect(data_get($package, 'autoload.psr-4'))->each(function ($entry, $namespace) use ($module) {
                            $module->offsetSet('namespace', $namespace);
                            $module->offsetSet('service', $namespace . 'ModuleServiceProvider');
                        });
                        $provider = $module->offsetGet('service');
                        $module->offsetSet('initialized', boolval(class_exists($provider) ?: false));
                        $key = 'module.' . $module->offsetGet('identification') . '.enabled';
                        $module->offsetSet('enabled', boolval($this->setting()->get($key, false)));
                        $key = 'module.' . $module->offsetGet('identification') . '.installed';
                        $module->offsetSet('installed', boolval($this->setting()->get($key, false)));
                    }
                    $this->items[$configurations->get('identification')] = $module;
                }
            });
            $this->initialized = true;
        }
    }

    /**
     * @param string $directory
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    protected function loadConfigurations(string $directory)
    {
        if ($this->file()->exists($file = $directory . DIRECTORY_SEPARATOR . 'configuration.yaml')) {
            return collect(Yaml::parse(file_get_contents($file)));
        } else {
            if ($this->file()->isDirectory($directory = $directory . DIRECTORY_SEPARATOR . 'configurations')) {
                $configurations = collect();
                collect($this->file()->files($directory))->each(function ($file) use ($configurations) {
                    if ($this->file()->isReadable($file)) {
                        collect(Yaml::dump(file_get_contents($file)))->each(function ($data, $key) use ($configurations) {
                            $configurations->put($key, $data);
                        });
                    }
                });

                return $configurations;
            } else {
                throw new \Exception('Load Module fail: ' . $directory);
            }
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function enabled(): Collection
    {
        return $this->filter(function (Module $module) {
            return $module->get('enabled') == true;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function installed(): Collection
    {
        return $this->filter(function (Module $module) {
            return $module->get('installed') == true;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function notInstalled(): Collection
    {
        return $this->filter(function (Module $module) {
            return $module->get('installed') == false;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function loaded(): Collection
    {
        return $this->filter(function (Module $module) {
            return $module->get('initialized') == true;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function notLoaded(): Collection
    {
        return $this->filter(function (Module $module) {
            return $module->get('initialized') == false;
        });
    }
}
