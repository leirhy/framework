<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-14 07:49:09
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreatePermissionsTable.
 */
class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('permissions');
    }
}
