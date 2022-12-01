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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
			$table->string('serial_admin',6)->unique()->comment('管理者用シリアル');
			$table->string('email')->unique()->unique()->comment('メールアドレス');
			$table->timestamp('email_verified_at')->nullable();
			$table->string('phone',20)->nullable()->comment('電話番号');
			$table->string('email_tmp')->nullable()->comment('メールアドレスの退避');
			$table->string('password')->nullable()->comment('パスワード');
			$table->string('verify_code',10)->nullable()->comment('二要素認証用コード');
			$table->string('verify_date',10)->default('false')->comment('認証チェック');
			$table->rememberToken()->comment('ログイン省略トークン');
			$table->text('profile_photo_path')->nullable();
			$table->string('last_name_kanji',100)->nullable()->comment('姓');
			$table->string('first_name_kanji',100)->nullable()->comment('名');
			$table->string('last_name_jp_kana',100)->nullable()->comment('セイ');
			$table->string('first_name_jp_kana',100)->nullable()->comment('メイ');
			$table->string('last_name_eng',100)->nullable()->comment('Last Name');
			$table->string('first_name_eng',100)->nullable()->comment('First Name');
			$table->text('address')->nullable()->comment('住所');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
};
