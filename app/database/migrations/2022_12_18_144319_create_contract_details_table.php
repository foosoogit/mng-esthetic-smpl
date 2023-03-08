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
        Schema::create('contract_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('contract_detail_serial',30)->unique()->comment('契約詳細シリアル');
            $table->string('serial_keiyaku',30)->comment('契約番号');
            
            $table->string('serial_user',10)->comment('serial_user');
            $table->string('serial_staff',10)->nullable()->comment('ID Staff');
            $table->string('keiyaku_naiyo')->nullable()->comment('契約内容');
            
            $table->string('keiyaku_num',20)->nullable()->comment('回数');
            $table->string('unit_price',15)->nullable()->comment('単価');
            $table->string('price',15)->nullable()->comment('料金');
            
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_details');
    }
};
