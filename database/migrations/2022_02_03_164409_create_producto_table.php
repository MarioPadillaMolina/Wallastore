<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Producto;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            //         PRODUCTO: id, iduser, idcategoria, nombre, descripcion, precio, uso, fecha, estado(en venta, vendido, retirado, otros), 
            // foto (1 o más) - Si no tiene foto no se publicita (SOFTDELETES)
            $table->id();

            $table->string('nombre', 200);
            $table->decimal('precio', 7, 2);
            $table->string('descripcion');
            $table->date('fecha')->default(now());
            $table->bigInteger('uso_id')->unsigned();
            $table->bigInteger('categoria_id')->unsigned();
            $table->bigInteger('estado_id')->unsigned()->default(0);
            $table->bigInteger('user_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('categoria_id')->references('id')->on('categoria');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('uso_id')->references('id')->on('uso');
            $table->foreign('estado_id')->references('id')->on('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
