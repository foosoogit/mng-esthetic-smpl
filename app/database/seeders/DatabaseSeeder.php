<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        /*
        $init_staffs = [
			[
			'serial_staff'=> 'S_0001',
			'email' => 'moezbeauty.ts@gmail.com',
			'password' => '0101',
			'last_name_kanji' => '鈴木',
			'first_name_kanji' => '和弘',
			'last_name_jp_kana' => 'スズキ',
			'first_name_jp_kana' => 'カズヒロ',
			'last_name_eng'=> 'Suzuki',
			'first_name_eng'=> 'Kazuhiro',
			'phone'=> '000-0000-0000',
			'address'=> '東京都世田谷区************',
            ],
            [
			'serial_staff'=> 'S_0002',
            'email' => 'awa@szemi-gp.com',
			'password' => '000000',
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

        foreach($init_staffs as $init_staff) {
			$staff = new StaffSeeder();
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
        */
    }
}
