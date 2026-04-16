<?php

namespace Database\Seeders;

use App\Models\Couch;
use App\Models\User;
use Illuminate\Database\Seeder;

class CouchSeeder extends Seeder
{
  public function run(): void
  {
    $users = User::role('customer')->take(3)->get();

    $couchesInfo = [
      [
        'name' => ['ar' => 'الكابتن عصام منصور', 'en' => 'Coach Issam Mansour'],
        'phone' => '+963912345678',
        'address' => ['ar' => 'دمشق - المزة', 'en' => 'Damascus - Mezzeh']
      ],
      [
        'name' => ['ar' => 'الكابتن منى الشهابي', 'en' => 'Coach Mona Al-Shahabi'],
        'phone' => '+963922334455',
        'address' => ['ar' => 'حلب - الشهباء', 'en' => 'Aleppo - Al-Shahbaa']
      ],
      [
        'name' => ['ar' => 'الكابتن خالد العلي', 'en' => 'Coach Khaled Al-Ali'],
        'phone' => '+963933445566',
        'address' => ['ar' => 'اللاذقية - المشروع', 'en' => 'Latakia - Al-Mashroua']
      ],
      [
        'name' => ['ar' => 'الكابتن رامي الحسن', 'en' => 'Coach Rami Al-Hassan'],
        'phone' => '+963944556677',
        'address' => ['ar' => 'حمص - الإنشاءات', 'en' => 'Homs - Al-Inshaat']
      ],
      [
        'name' => ['ar' => 'الكابتن ليلى بركات', 'en' => 'Coach Layla Barakat'],
        'phone' => '+963955667788',
        'address' => ['ar' => 'طرطوس - الكورنيش', 'en' => 'Tartous - Corniche']
      ],
      [
        'name' => ['ar' => 'الكابتن سامر المصري', 'en' => 'Coach Samer Al-Masri'],
        'phone' => '+963966778899',
        'address' => ['ar' => 'دمشق - مشروع دمر', 'en' => 'Damascus - Dummar Project']
      ],
      [
        'name' => ['ar' => 'الكابتن هبة النوري', 'en' => 'Coach Heba Al-Nouri'],
        'phone' => '+963977889900',
        'address' => ['ar' => 'حلب - الفرقان', 'en' => 'Aleppo - Al-Furqan']
      ],
      [
        'name' => ['ar' => 'الكابتن يحيى زكريا', 'en' => 'Coach Yahya Zakaria'],
        'phone' => '+963988990011',
        'address' => ['ar' => 'حماة - حي الأندلس', 'en' => 'Hama - Al-Andalus']
      ],
      [
        'name' => ['ar' => 'الكابتن نور القاسم', 'en' => 'Coach Nour Al-Qasim'],
        'phone' => '+963999001122',
        'address' => ['ar' => 'السويداء - وسط المدينة', 'en' => 'Suwayda - City Center']
      ],
      [
        'name' => ['ar' => 'الكابتن مازن عيسى', 'en' => 'Coach Mazen Issa'],
        'phone' => '+963911002233',
        'address' => ['ar' => 'ريف دمشق - جرمانا', 'en' => 'Rif Damascus - Jaramana']
      ],
    ];

    foreach ($users as $index => $user) {
      if (isset($couchesInfo[$index])) {
        Couch::updateOrCreate(
          ['user_id' => $user->id],
          [
            'name' => $couchesInfo[$index]['name'],
            'phone' => $couchesInfo[$index]['phone'],
            'address' => $couchesInfo[$index]['address'],
          ]
        );
      }
    }
  }
}
