<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcel_id')->unsigned();
            $table->string('description', 256);
            $table->integer('quantity')->unsigned()->default(1);
            $table->float('weight', 4, 2);
            $table->timestamps();
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_items');
    }
}
