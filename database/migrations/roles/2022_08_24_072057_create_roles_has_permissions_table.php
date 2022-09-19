<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
           }

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
             $table->unsignedBigInteger('permission_id');
                      $table->unsignedBigInteger('role_id');

                      $table->foreign('permission_id')
                          ->references('id')
                          ->on($tableNames['permissions'])
                          ->onDelete('cascade');

                      $table->foreign('role_id')
                          ->references('id')
                          ->on($tableNames['roles'])
                          ->onDelete('cascade');

                      $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_has_permissions');
    }
};
