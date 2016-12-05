<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 20:41
 */
namespace Notadd\Foundation\Database\Migrations;

use Illuminate\Database\ConnectionInterface;

/**
 * Class Migration.
 */
abstract class Migration
{
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Migration constructor.
     *
     * @param \Illuminate\Database\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->schema = call_user_func([
            $connection,
            'getSchemaBuilder',
        ]);
    }

    /**
     * @return void
     */
    abstract public function down();

    /**
     * @return string
     */
    public function getConnection()
    {
        return '';
    }

    /**
     * @return void
     */
    abstract public function up();
}
