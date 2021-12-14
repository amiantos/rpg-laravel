<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('short_name');

            $table->integer('level');
            $table->integer('quality');
            $table->integer('material');
            $table->integer('damage');
            $table->integer('weight');

            $table->integer('durability');
            $table->integer('max_durability');

            
            // foreign keys

            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('in_room_id')->nullable();
            $table->foreign('in_room_id')->references('id')->on('rooms');

            $table->unsignedBigInteger('in_character_id')->nullable();
            $table->foreign('in_character_id')->references('id')->on('characters');

            // $table->unsignedBigInteger('in_npc_id')->nullable();
            // $table->foreign('in_npc_id')->references('id')->on('npcs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weapons');
    }
}
