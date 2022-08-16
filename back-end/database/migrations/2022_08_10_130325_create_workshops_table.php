<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->datetime('heure_debut');
            $table->datetime('heure_fin'); 
            $table->foreignId('organisateur_id');
            $table->foreign('organisateur_id')->references('id')->on('users');
            $table->foreignId('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');;
            $table->foreignId('leader_id');
            $table->foreign('leader_id')->references('id')->on('users')->onDelete('cascade');;
            $table->integer('status');

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
        Schema::dropIfExists('workshops');
    }
};
