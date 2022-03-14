<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('item_name',30);
            $table->integer('item_number',false,false)->unsigned();
            $table->string('item_category',10);
            $table->text('item_text',1000);
            $table->integer('star',false,false)->default(null)->nullable();
            $table->text('image')->default(null)->nullable();
            $table->integer('price',false,false)->unsigned();
            $table->integer('discount_price',false,false)->unsigned()->default(null)->nullable();
            $table->timestamp('update_at')->useCurrent()->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
