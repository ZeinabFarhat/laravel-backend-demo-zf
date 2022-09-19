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
         Schema::create( 'monitas', function ( Blueprint $table ) {
                   $table->bigIncrements( 'id' );

                   $table->string( 'name' );

                   $table->timestamps();
               } );

               Schema::create('model_can_monita', function (Blueprint $table) {
                   $table->unsignedBigInteger('monita_id');

                   $table->string('model_type');
                   $table->unsignedBigInteger('model_id');
                   $table->index(['model_id', 'model_type', ], 'model_has_monitas_model_id_model_type_index');

                   $table->foreign('monita_id')
                         ->references('id')
                         ->on('monitas')
                         ->onDelete('cascade');

                   $table->primary(['monita_id', 'model_id', 'model_type'],
                       'model_has_monitas_monita_model_type_primary');
               });

               Schema::create( 'role_can_monita', function ( Blueprint $table ) {
                   $table->bigIncrements( 'id' );

                   $table->unsignedInteger( 'role_id' );
                   $table->foreign( 'role_id' )->references( 'id' )->on( 'roles' )->onDelete( 'cascade' );

                   $table->unsignedBigInteger( 'monita_id' );
                   $table->foreign( 'monita_id' )->references( 'id' )->on( 'monitas' )->onDelete( 'cascade' );
               } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::dropIfExists( 'role_can_monita' );
               Schema::dropIfExists( 'model_can_monita' );
               Schema::dropIfExists( 'monitas' );
    }
};
