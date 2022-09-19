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
            Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
                   $table->unsignedBigInteger('permission_id');

                   $table->string('model_type');
                   $table->unsignedBigInteger($columnNames['model_morph_key']);
                   $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

                   $table->foreign('permission_id')
                       ->references('id')
                       ->on($tableNames['permissions'])
                       ->onDelete('cascade');

                   $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                           'model_has_permissions_permission_model_type_primary');
               });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mode_has_permissions');
    }
};