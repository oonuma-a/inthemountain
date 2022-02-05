<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItem extends Migration
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
            $table->string('user_id',30);
            $table->string('item_name',30);
            $table->string('item_category',10);
            $table->text('item_text',1000);
            $table->text('image');
            $table->integer('price',false,false)->unsigned();
            $table->integer('discount_flg',false,false)->unsigned()->default('0')->length(1);
            $table->integer('discount_price',false,false)->unsigned()->default(null)->nullable();
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
