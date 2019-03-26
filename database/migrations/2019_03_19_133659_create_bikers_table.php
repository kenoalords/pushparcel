<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bikers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 36);
            $table->string('address', 128);
            $table->string('phone', 24);
            $table->integer('age')->unsigned();
            $table->integer('bike')->unsigned();
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
        Schema::dropIfExists('bikers');
    }
}
