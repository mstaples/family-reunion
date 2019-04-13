<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsvpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('days');
            $table->boolean('exists')->default(false);
            $table->boolean('private')->default(false);
            $table->boolean('pet')->default(false);
            $table->boolean('paid')->default(false);
            $table->boolean('has_rsvp')->default(false);
            $table->integer('has_paid')->default(0);
            $table->integer('balance')->default(0);
            $table->integer('nights')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('rsvps');
    }
}
