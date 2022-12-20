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
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
			$table->string('serial_good',30)->nullable();
			$table->string('model_number',30)->nullable()->comment('型番');
			
            $table->string('good_name')->nullable()->comment('商品名');
            $table->string('buying_price',20)->nullable()->comment('仕入れ値');
            $table->string('selling_price',20)->nullable()->comment('売値');

			$table->string('zaiko',5)->nullable()->comment('在庫数');
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
        Schema::dropIfExists('goods');
    }
};
