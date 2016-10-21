<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:14
 */
namespace Notadd\Foundation\Console;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class ModelMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class ModelMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:model';
    /**
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';
    /**
     * @var string
     */
    protected $type = 'Model';
    /**
     * @return void
     */
    public function fire() {
        if(parent::fire() !== false) {
            if($this->option('migration')) {
                $table = Str::plural(Str::snake(class_basename($this->argument('name'))));
                $this->call('make:migration', [
                    'name' => "create_{$table}_table",
                    '--create' => $table
                ]);
            }
            if($this->option('controller')) {
                $controller = Str::camel(class_basename($this->argument('name')));
                $this->call('make:controller', [
                    'name' => "{$controller}Controller",
                    '--resource' => true
                ]);
            }
        }
    }
    /**
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/model.stub';
    }
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace;
    }
    /**
     * @return array
     */
    protected function getOptions() {
        return [
            [
                'migration',
                'm',
                InputOption::VALUE_NONE,
                'Create a new migration file for the model.'
            ],
            [
                'controller',
                'c',
                InputOption::VALUE_NONE,
                'Create a new resource controller for the model.'
            ],
        ];
    }
}