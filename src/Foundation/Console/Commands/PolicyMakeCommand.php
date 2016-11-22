<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:16
 */
namespace Notadd\Foundation\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PolicyMakeCommand.
 */
class PolicyMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:policy';
    /**
     * @var string
     */
    protected $description = 'Create a new policy class';
    /**
     * @var string
     */
    protected $type = 'Policy';

    /**
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * @param string $stub
     * @param string $model
     *
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);
        if (Str::startsWith($model, '\\')) {
            $stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyModel', $this->laravel->getNamespace() . $model, $stub);
        }
        $model = class_basename(trim($model, '\\'));
        $stub = str_replace('DummyModel', $model, $stub);
        $stub = str_replace('dummyModelName', Str::camel($model), $stub);

        return str_replace('dummyPluralModelName', Str::plural(Str::camel($model)), $stub);
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('model')) {
            return __DIR__ . '/stubs/policy.stub';
        }

        return __DIR__ . '/stubs/policy.plain.stub';
    }

    /**
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Policies';
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'model',
                'm',
                InputOption::VALUE_OPTIONAL,
                'The model that the policy applies to.',
            ],
        ];
    }
}
