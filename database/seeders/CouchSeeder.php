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
        'name' => ['ar' => 'الكابتن عصام', 'en' => 'Coach Issam'],
        'phone' => '+963912345678',
        'address' => ['ar' => 'دمشق - المزة', 'en' => 'Damascus - Mezzeh']
      ],
      [
        'name' => ['ar' => 'الكابتن منى', 'en' => 'Coach Mona'],
        'phone' => '+963922334455',
        'address' => ['ar' => 'حلب - الشهباء', 'en' => 'Aleppo - Al-Shahbaa']
      ],
      [
        'name' => ['ar' => 'الكابتن خالد', 'en' => 'Coach Khaled'],
        'phone' => '+963933445566',
        'address' => ['ar' => 'اللاذقية - المشروع', 'en' => 'Latakia - Al-Mashroua']
      ],
    ];

    foreach ($users as $index => $user) {
      if (isset($couchesInfo[$index])) {
        Couch::create([
          'user_id' => $user->id,
          'name' => $couchesInfo[$index]['name'],
          'phone' => $couchesInfo[$index]['phone'],
          'address' => $couchesInfo[$index]['address'],
        ]);
      }
    }
  }
}
