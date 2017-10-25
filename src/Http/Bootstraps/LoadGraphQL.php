<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-24 16:49
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class LoadGraphQL.
 */
class LoadGraphQL implements Bootstrap
{
    use Helpers;

    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        $paths = collect();
        $directories = $this->file->directories($this->container->frameworkPath('src'));
        foreach ($directories as $directory) {
            $graphql = realpath($directory . DIRECTORY_SEPARATOR . 'GraphQL');
            if ($this->file->isDirectory($graphql)) {
                $data = [];
                $data['graphql'] = '\\Notadd\\Foundation\\' . $this->file->name($directory) . '\\GraphQL';
                $mutation = $graphql . DIRECTORY_SEPARATOR . 'Mutations';
                if ($this->file->isDirectory($mutation)) {
                    foreach ($this->file->files($mutation) as $file) {
                        $class = $data['graphql'] . '\\Mutations\\' . $this->file->name($file);
                        if ($this->file->extension($file) == 'php' && class_exists($class)) {
                            $data['mutation'][] = $class;
                        }
                    }
                }
                $query = $graphql . DIRECTORY_SEPARATOR . 'Queries';
                if ($this->file->isDirectory($query)) {
                    foreach ($this->file->files($query) as $file) {
                        $class = $data['graphql'] . '\\Queries\\' . $this->file->name($file);
                        if ($this->file->extension($file) == 'php' && class_exists($class)) {
                            $data['query'][] = $class;
                        }
                    }
                }
                $type = $graphql . DIRECTORY_SEPARATOR . 'Types';
                if ($this->file->isDirectory($type)) {
                    foreach ($this->file->files($type) as $file) {
                        $class = $data['graphql'] . '\\Types\\' . $this->file->name($file);
                        if ($this->file->extension($file) == 'php' && class_exists($class)) {
                            $data['type'][] = $class;
                        }
                    }
                }
                $paths->push($data);
            }
        }
        $paths->each(function ($definition) {
            if (isset($definition['type'])) {
                foreach ((array)$definition['type'] as $type) {
                    $this->graphql->addType($type);
                }
            }
        });
    }
}
