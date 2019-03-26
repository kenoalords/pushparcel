<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->uuid('uuid');
            // Sender information
            $table->string('sender_name', 128);
            $table->string('sender_email', 128);
            $table->string('sender_phone', 128);
            $table->string('sender_address', 128);
            // Reciever information
            $table->string('receiver_name', 128);
            $table->string('receiver_phone', 128);
            $table->string('receiver_address', 128);
            $table->integer('distance')->unsigned();
            $table->integer('price')->unsigned();

            $table->enum('payment_type', ['pop', 'online'])->default('pop');
            $table->enum('status', ['pending', 'intransit', 'delivered', 'returned'])->default('pending');
            $table->integer('biker_id')->unsigned()->nullable();
            $table->dateTime('pickup_date')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('is_paid')->default(false);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcels');
    }
}
