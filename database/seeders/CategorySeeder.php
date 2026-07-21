<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      [
        'name' => [
          'ar' => 'معدات التنس',
          'en' => 'Tennis Equipment'
        ],
        'description' => [
          'ar' => 'أفضل مضارب وكرات التنس العالمية',
          'en' => 'Best world-class tennis rackets and balls'
        ],
        'image_url' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?q=80&w=800&auto=format&fit=crop',
      ],
      [
        'name' => [
          'ar' => 'ملابس رياضية',
          'en' => 'Sports Apparel'
        ],
        'description' => [
          'ar' => 'أطقم رياضية مريحة وعصرية للجنسين',
          'en' => 'Comfortable and trendy sports outfits for all'
        ],
        'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=800&auto=format&fit=crop',
      ],
      [
        'name' => [
          'ar' => 'أحذية رياضية',
          'en' => 'Sports Shoes'
        ],
        'description' => [
          'ar' => 'أحذية مخصصة للملاعب الصلبة والترابية',
          'en' => 'Shoes designed for hard and clay courts'
        ],
        'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop',
      ],
      [
        'name' => [
          'ar' => 'معدات البادل',
          'en' => 'Padel Equipment'
        ],
        'description' => [
          'ar' => 'مضارب البادل وكراته وأهم التجهيزات الخاصة باللعبة',
          'en' => 'Padel rackets, balls, and essential equipment for the game'
        ],
        'image_url' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=800&auto=format&fit=crop',
      ],
    ];

    foreach ($categories as $data) {
      $imageUrl = $data['image_url'];
      unset($data['image_url']);

      $category = Category::create($data);

      try {
        $category->addMediaFromUrl($imageUrl)
          ->toMediaCollection('categories');
      } catch (\Exception $e) {
        continue;
      }
    }
  }
}
