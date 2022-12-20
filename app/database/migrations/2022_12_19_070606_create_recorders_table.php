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
        Schema::create('recorders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('id_recorder',30)->nullable()->comment('記録者ID');
            $table->string('name_recorder',100)->nullable()->comment('記録者名');
            $table->string('location')->nullable()->comment('記録した場所');

            $table->string('location_url')->nullable()->comment('記録した場所のURL');
            $table->text('memo')->nullable()->comment('メモ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recorders');
    }
};
