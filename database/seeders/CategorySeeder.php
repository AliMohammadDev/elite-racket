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
      ],
      [
        'name' => [
          'ar' => 'حقائب وإكسسوارات',
          'en' => 'Bags & Accessories'
        ],
        'description' => [
          'ar' => 'حقائب مضارب وإكسسوارات متنوعة',
          'en' => 'Racket bags and various accessories'
        ],
      ],
    ];

    foreach ($categories as $categoryData) {
      Category::create($categoryData);
    }
  }
}