<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:14
 */
namespace Notadd\Foundation\Database\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ModelMakeCommand.
 */
class ModelMakeCommand extends GeneratorCommand
{
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
     * Command handler.
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            if ($this->option('migration')) {
                $table = Str::plural(Str::snake(class_basename($this->argument('name'))));
                $this->call('make:migration', [
                    'name'     => "create_{$table}_table",
                    '--create' => $table,
                ]);
            }
            if ($this->option('controller')) {
                $controller = Str::camel(class_basename($this->argument('name')));
                $this->call('make:controller', [
                    'name'       => "{$controller}Controller",
                    '--resource' => true,
                ]);
            }
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'migration',
                'm',
                InputOption::VALUE_NONE,
                'Create a new migration file for the model.',
            ],
            [
                'controller',
                'c',
                InputOption::VALUE_NONE,
                'Create a new resource controller for the model.',
            ],
        ];
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getPath($name)
    {
        $namespaces = collect(explode('\\', $name));
        $base = $name;
        $installed = require $this->laravel['path.base'] . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_psr4.php';
        for ($i = 0; $i < $namespaces->count(); $i++) {
            $base = str_replace($namespaces->pop(), '', trim($base, '\\'));
            foreach ($installed as $namespace => $paths) {
                if ($base == $namespace) {
                    foreach ($paths as $path) {
                        $base = [
                            $namespace,
                            $path,
                        ];
                        break;
                    }
                }
            }
        }
        if (is_array($base)) {
            list($root, $path) = $base;

            return $path . '/' . str_replace('\\', '/', str_replace($root, '', $name)) . '.php';
        }

        throw new RuntimeException('Unable to detect model\'s path.');
    }

    /**
     * Get stub file.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../stubs/models/model.stub';
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return trim($name, '\\');
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string  $stub
     * @param string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            'DummyNamespace', $this->getNamespace($name), $stub
        );

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
    }
}
