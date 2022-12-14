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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('serial_user')->unique();
			$table->string('last_name_kanji',100)->nullable()->comment('姓');
			$table->string('first_name_kanji',100)->nullable()->comment('名');
			$table->string('last_name_jp_kana',100)->nullable()->comment('セイ');
			$table->string('first_name_jp_kana',100)->nullable()->comment('メイ');
			$table->string('last_name_eng',100)->nullable()->comment('Last Name');
			$table->string('first_name_eng',100)->nullable()->comment('First Name');
			$table->string('gender',10)->nullable();
			$table->string('birth_year',10)->nullable();
			$table->string('birth_month',10)->nullable();
			$table->string('birth_day',10)->nullable();
			$table->string('postal',15)->nullable();
			$table->string('address_region')->nullable();
			$table->string('address_locality')->nullable();
			$table->string('address_banti')->nullable();
			$table->string('email')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('phone',20)->nullable();
            $table->foreignId('current_team_id')->nullable();
			$table->text('profile_photo_path',50)->nullable();
            $table->text('address')->nullable()->comment('住所');
			$table->string('password')->nullable();
			$table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
