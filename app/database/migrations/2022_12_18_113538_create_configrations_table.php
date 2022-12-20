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
        Schema::create('configrations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('subject',50)->comment('項目 ID');
            $table->string('value1',50)->comment('Value-1');
            $table->text('value2')->comment('Value-2');
            $table->text('setumei')->comment('説明');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configrations');
    }
};
