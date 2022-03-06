<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('user_id',30);
            $table->text('password');
            $table->string('user_name',100);
            $table->string('email')->unique();
            $table->integer('user_authority',false,false)->length(1);
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
        Schema::dropIfExists('users');
    }
}
