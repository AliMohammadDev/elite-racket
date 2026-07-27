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
        'discounts' => 10,
        'image_url' => 'https://ar.reformsports.com/axemudsy/2020/10/sentetik-cim-tenis-kortu-img-1.jpg',
      ],
      [
        'name' => ['ar' => 'ملعب البادل الاحترافي A', 'en' => 'Pro Padel Court A'],
        'price' => 200,
        'discounts' => 0,
        'image_url' => 'https://turkan-eg.com/wp-content/uploads/2023/02/4-2.webp',
      ],
      [
        'name' => ['ar' => 'الملعب الرملي (ترابي)', 'en' => 'Clay Court - Red'],
        'price' => 120,
        'discounts' => 5,
        'image_url' => 'https://m.arabic.rubberrunningtrack.com/photo/pt34088483-itf_indoor_tennis_court_flooring_green_tennis_court_synthetic_flooring.jpg',
      ],
      [
        'name' => ['ar' => 'ملعب التدريب المغلق', 'en' => 'Indoor Training Court'],
        'price' => 180,
        'discounts' => 15,
        'image_url' => 'https://integralspor.com/assets/filemanager/25d2f90ac5e67564a386540fc4070c6e.jpg',
      ],
      [
        'name' => ['ar' => 'ملعب التنس الصلب (Hard)', 'en' => 'Hard Surface Tennis Court'],
        'price' => 140,
        'discounts' => 0,
        'image_url' => 'https://image.made-in-china.com/202f0j00wDFoJmKaMHzY/Socketed-Tennis-Pole-Outdoor-Steel-Tennis-Court.webp',
      ],
      [
        'name' => ['ar' => 'ملعب البادل VIP', 'en' => 'VIP Padel Court'],
        'price' => 300,
        'discounts' => 20,
        'image_url' => 'https://ar.citygreenturf.com/attachment/4/source/Padel_court_1_168201.jpg',
      ],
      [
        'name' => ['ar' => 'ملعب تنس للأطفال', 'en' => 'Junior Tennis Court'],
        'price' => 80,
        'discounts' => 5,
        'image_url' => 'https://www.mouratoglou.com/wp-content/uploads/2026/02/eccb3c8b-b71d-4748-ba32-1d8431b5fc9e-boca91-1920x0-c-default.webp',
      ],
      [
        'name' => ['ar' => 'الملعب الأولمبي', 'en' => 'Olympic Championship Court'],
        'price' => 250,
        'discounts' => 10,
        'image_url' => 'https://www.bivillage.com/wp-content/uploads/2024/04/padel-banner.jpg',
      ],
    ];

    foreach ($courts as $courtData) {
      $imageUrl = $courtData['image_url'];
      unset($courtData['image_url']);

      $court = Court::updateOrCreate(
        ['name->ar' => $courtData['name']['ar']],
        $courtData
      );

      if (!$court->hasMedia('courts')) {
        try {
          $court->addMediaFromUrl($imageUrl)
            ->toMediaCollection('courts');
        } catch (\Exception $e) {
          continue;
        }
      }
    }
  }
}
