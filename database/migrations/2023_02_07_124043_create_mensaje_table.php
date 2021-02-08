<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensaje', function (Blueprint $table) {
            $table->id();

            $table->text('mensaje');
            $table->boolean('leido')->default(0);
            $table->bigInteger('emisor_id')->unsigned();
            $table->bigInteger('receptor_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();

            $table->timestamps();

            $table->foreign('emisor_id')->references('id')->on('users');
            $table->foreign('receptor_id')->references('id')->on('users');
            $table->foreign('producto_id')->references('id')->on('producto');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensaje');
    }
}
