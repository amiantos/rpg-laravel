<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->integer('level')->default(1);
            $table->bigInteger('experience')->default(0);
            $table->bigInteger('experience_to_next_level')->default(100);
            $table->integer('turn_count')->default(0);

            $table->integer('strength')->default(1);
            $table->integer('dexterity')->default(1);
            $table->integer('constitution')->default(1);
            $table->integer('intelligence')->default(1);
            $table->integer('luck')->default(1);

            $table->integer('skill_points_earned')->default(0);
            $table->integer('skill_points_available')->default(0);

            $table->integer('max_health')->default(100);
            $table->integer('health')->default(100);

            $table->boolean('is_dead')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
