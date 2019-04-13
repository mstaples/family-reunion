<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contribution_text')->default("none");
            $table->string('contribution_email')->default("none");
            $table->string('preparation_text')->default("none");
            $table->string('preparation_email')->default("none");
            $table->timestamp('last_contribution_email')->nullable();
            $table->timestamp('last_contribution_text')->nullable();
            $table->timestamp('last_preparation_email')->nullable();
            $table->timestamp('last_preparation_text')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
