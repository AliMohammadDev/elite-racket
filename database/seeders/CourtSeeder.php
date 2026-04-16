<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
  public function run(): void
  {
    $courts = [
      [
        'name' => ['ar' => 'ملعب التنس الرئيسي (عشبي)', 'en' => 'Main Grass Tennis Court'],
        'price' => 150,
        'discounts' => 10
      ],
      [
        'name' => ['ar' => 'ملعب البادل الاحترافي A', 'en' => 'Pro Padel Court A'],
        'price' => 200,
        'discounts' => 0
      ],
      [
        'name' => ['ar' => 'الملعب الرملي (ترابي)', 'en' => 'Clay Court - Red'],
        'price' => 120,
        'discounts' => 5
      ],
      [
        'name' => ['ar' => 'ملعب التدريب المغلق', 'en' => 'Indoor Training Court'],
        'price' => 180,
        'discounts' => 15
      ],
      [
        'name' => ['ar' => 'ملعب التنس الصلب (Hard)', 'en' => 'Hard Surface Tennis Court'],
        'price' => 140,
        'discounts' => 0
      ],
      [
        'name' => ['ar' => 'ملعب البادل VIP', 'en' => 'VIP Padel Court'],
        'price' => 300,
        'discounts' => 20
      ],
      [
        'name' => ['ar' => 'ملعب تنس للأطفال', 'en' => 'Junior Tennis Court'],
        'price' => 80,
        'discounts' => 5
      ],
      [
        'name' => ['ar' => 'الملعب الأولمبي', 'en' => 'Olympic Championship Court'],
        'price' => 250,
        'discounts' => 10
      ],
    ];

    foreach ($courts as $courtData) {
      Court::updateOrCreate(
        ['name->ar' => $courtData['name']['ar']],
        $courtData
      );
    }
  }
}