<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$init_users = [
			[
			'serial_user'=> "S_0001",
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
			'serial_user'=> 'S_0002',
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

		foreach($init_users as $init_user) {
			$user = new User();
			$user->serial_user=$init_user['serial_user'];
			$user->last_name_kanji = $init_user['last_name_kanji'];
			$user->first_name_kanji = $init_user['first_name_kanji'];
			$user->last_name_jp_kana = $init_user['last_name_jp_kana'];
			$user->first_name_jp_kana = $init_user['first_name_jp_kana'];
			$user->last_name_eng = $init_user['last_name_eng'];
			$user->first_name_eng = $init_user['first_name_eng'];
			$user->email = $init_user['email'];
			$user->phone = $init_user['phone'];
			$user->address = $init_user['address'];
			$user->password = Hash::make($init_user['password']);
			$user->save();
		}
    }
}
