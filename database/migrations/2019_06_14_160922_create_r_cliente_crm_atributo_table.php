<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRClienteCrmAtributoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_cliente_crm_atributo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('crm_atributo_id')->unsigned();
            $table->string('valor');
            $table->timestamps();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('cliente')
                ->onDelete('cascade');

            $table->foreign('crm_atributo_id')
                ->references('id')
                ->on('crm_atributo')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_cliente_crm_atributo');
    }
}
