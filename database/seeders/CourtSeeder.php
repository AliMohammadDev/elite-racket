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
        'image_url' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?q=80&w=1000&auto=format&fit=crop', // ملعب تنس عشبي احترافي
      ],
      [
        'name' => ['ar' => 'ملعب البادل الاحترافي A', 'en' => 'Pro Padel Court A'],
        'price' => 200,
        'discounts' => 0,
        'image_url' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=1000&auto=format&fit=crop', // ملعب بادل زجاجي حديث
      ],
      [
        'name' => ['ar' => 'الملعب الرملي (ترابي)', 'en' => 'Clay Court - Red'],
        'price' => 120,
        'discounts' => 5,
        'image_url' => 'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?q=80&w=1000&auto=format&fit=crop', // ملعب تنس ترابي أحمر
      ],
      [
        'name' => ['ar' => 'ملعب التدريب المغلق', 'en' => 'Indoor Training Court'],
        'price' => 180,
        'discounts' => 15,
        'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1000&auto=format&fit=crop', // ملعب تنس داخلي مغلق
      ],
      [
        'name' => ['ar' => 'ملعب التنس الصلب (Hard)', 'en' => 'Hard Surface Tennis Court'],
        'price' => 140,
        'discounts' => 0,
        'image_url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1000&auto=format&fit=crop', // ملعب تنس صلب أزرق
      ],
      [
        'name' => ['ar' => 'ملعب البادل VIP', 'en' => 'VIP Padel Court'],
        'price' => 300,
        'discounts' => 20,
        'image_url' => 'https://images.unsplash.com/photo-1511882150382-421056c89033?q=80&w=1000&auto=format&fit=crop', // ملعب بادل بانورامي فاخر
      ],
      [
        'name' => ['ar' => 'ملعب تنس للأطفال', 'en' => 'Junior Tennis Court'],
        'price' => 80,
        'discounts' => 5,
        'image_url' => 'https://images.unsplash.com/photo-1517649763962-0c6232660d02?q=80&w=1000&auto=format&fit=crop', // أجواء ملاعب تدريبية مصغرة
      ],
      [
        'name' => ['ar' => 'الملعب الأولمبي', 'en' => 'Olympic Championship Court'],
        'price' => 250,
        'discounts' => 10,
        'image_url' => 'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?q=80&w=1000&auto=format&fit=crop', // ملعب بطولات كبرى
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
