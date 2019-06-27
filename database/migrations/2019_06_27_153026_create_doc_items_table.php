<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('excerpt');
            $table->string('comment');
            $table->string('link1');
            $table->string('link2');
            $table->string('attachment1_url');
            $table->string('attachment2_url');
            $table->string('attachment3_url');
            $table->string('desc_att1');
            $table->string('desc_att2');
            $table->string('desc_att3');
            $table->boolean('enabled',true);

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
        Schema::dropIfExists('docs_items');
    }
}
