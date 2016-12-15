<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 15:38
 */
namespace Notadd\Foundation\Database\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as IlluminateMigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Application;

/**
 * Class MigrationCreator.
 */
class MigrationCreator extends IlluminateMigrationCreator
{
    /**
     * @var \Notadd\Foundation\Application
     */
    protected $application;

    /**
     * MigrationCreator constructor.
     *
     * @param \Notadd\Foundation\Application    $application
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Application $application, Filesystem $filesystem)
    {
        parent::__construct($filesystem);
        $this->application = $application;
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../stubs/migrations';
    }
}
