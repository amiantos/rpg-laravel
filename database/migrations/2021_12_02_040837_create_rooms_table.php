<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            $table->integer('z')->default(1);

            $table->unsignedBigInteger('north')->nullable();
            $table->foreign('north')->references('id')->on('rooms');

            $table->unsignedBigInteger('south')->nullable();
            $table->foreign('south')->references('id')->on('rooms');

            $table->unsignedBigInteger('east')->nullable();
            $table->foreign('east')->references('id')->on('rooms');

            $table->unsignedBigInteger('west')->nullable();
            $table->foreign('west')->references('id')->on('rooms');

            $table->unsignedBigInteger('above')->nullable();
            $table->foreign('above')->references('id')->on('rooms');

            $table->unsignedBigInteger('below')->nullable();
            $table->foreign('below')->references('id')->on('rooms');

            $table->boolean('filled')->default(false);

            $table->text('description')->default("This room does not have a description yet.");
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });

        Schema::dropIfExists('rooms');
    }
}
