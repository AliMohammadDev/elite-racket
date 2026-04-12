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
        'name' => ['ar' => 'ملعب التنس الرئيسي', 'en' => 'Main Tennis Court'],
        'price' => 150,
        'discounts' => 10
      ],
      [
        'name' => ['ar' => 'ملعب البادل الاحترافي', 'en' => 'Pro Padel Court'],
        'price' => 200,
        'discounts' => 0
      ],
      [
        'name' => ['ar' => 'الملعب الرملي', 'en' => 'Clay Court'],
        'price' => 120,
        'discounts' => 5
      ],
      [
        'name' => ['ar' => 'ملعب التدريب المغلق', 'en' => 'Indoor Training Court'],
        'price' => 180,
        'discounts' => 15
      ],
    ];

    foreach ($courts as $courtData) {
      Court::create($courtData);
    }
  }
}