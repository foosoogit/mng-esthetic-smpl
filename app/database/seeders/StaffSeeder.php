<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\Staff::factory()->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $init_staffs = [
			[
			'serial_staff'=> "S_0001",
			'email' => "moezbeauty.ts@gmail.com",
			'password' => "0101",
			'last_name_kanji' => "鈴木",
			'first_name_kanji' => "和弘",
			'last_name_jp_kana' => "スズキ",
			'first_name_jp_kana' => "カズヒロ",
			'last_name_eng'=> "Suzuki",
			'first_name_eng'=> "Kazuhiro",
			'phone'=> "000-0000-0000",
			'address'=> "東京都世田谷区************",
            ],
            [
			'serial_staff'=> 'S_0002',
            'email' => 'awa@szemi-gp.com',
			'password' => '0102',
			'last_name_kanji' => '鈴木',
			'first_name_kanji' => '文彦',
			'last_name_jp_kana' => 'スズキ',
			'first_name_jp_kana' => 'フミヒコ',
			'last_name_eng'=> 'Suzuki',
			'first_name_eng'=> 'Fumihiko',
			'phone'=> '000-0000-0000',
			'address'=> '千葉県木更津市************',
			]
        ];

        /*
        $table->string('serial_staff',6)->unique()->comment('管理者用シリアル');
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
        */

		foreach($init_staffs as $init_staff) {
			$staff = new Staff();
			$staff->serial_staff=$init_staff['serial_staff'];
			$staff->last_name_kanji = $init_staff['last_name_kanji'];
			$staff->first_name_kanji = $init_staff['first_name_kanji'];
			$staff->last_name_jp_kana = $init_staff['last_name_jp_kana'];
			$staff->first_name_jp_kana = $init_staff['first_name_jp_kana'];
			$staff->last_name_eng = $init_staff['last_name_eng'];
			$staff->first_name_eng = $init_staff['first_name_eng'];
			$staff->email = $init_staff['email'];
			$staff->phone = $init_staff['phone'];
			$staff->address = $init_staff['address'];
			$staff->password = Hash::make($init_staff['password']);
			$staff->save();
		}

		/*
		$init_users =[ 
			[
				'email' => 'awa@szemi-gp.com',
				'password' => '111111',
				'name_sei' => '鈴木文彦',
				'serial_user' => 'U_00001'
			]
		];
		foreach($init_users as $init_user) {
			$user = new User();
			$user->email = $init_user['email'];
			$user->name = $init_user['name'];
			$user->serial_user = $init_user['serial_user'];
			$user->password = Hash::make($init_user['password']);
			$user->save();
		}
		*/
		/*		
		$init_staffs =[ 
			[
				'name' => 'fsuzuki',
				'serial_staff' => 'a_001',
				'email' => 'awa@szemi-gp.com',
				'password' => '111111'
			]
		];
		foreach($init_staffs as $init_staff) {
			$staff = new Staff();
			$staff->name= $init_staff['name'];
			$staff->serial_staff= $init_staff['serial_staff'];
			$staff->email = $init_staff['email'];
			$staff->password = Hash::make($init_staff['password']);
			$staff->save();
		}
        */
    }
}
