<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

  private $categoryImages = [
    'Tennis Equipment' => [
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496754/Tennis1_l5xyij.jpg',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496752/Tennis3_poqtgh.jpg',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496886/tennis1_vigyhg.jpgjpg',
    ],
    'Sports Apparel' => [
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496914/Appreal1_yrzazc.jpg',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496913/Appreal3_eybgka.jpg',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496912/Appreal2_hbvcjn.jpg',
    ],
    'Sports Shoes' => [
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496966/shose3_s28nb5.jpg',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776496963/shose1_u0nksk.jpg',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776497057/chose2_hdfc4h.webp',
    ],
    'Padel Equipment' => [
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776497150/paddle1_vktp5p.webp',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776497149/paddle3_dhbxch.webp',
      'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776497150/paddle2_pxvbyk.jpg',
    ],
  ];

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
          'ar' => 'معدات البادل',
          'en' => 'Padel Equipment'
        ],
        'description' => [
          'ar' => 'مضارب البادل وكراته وأهم التجهيزات الخاصة باللعبة',
          'en' => 'Padel rackets, balls, and essential equipment for the game'
        ],
      ],
    ];

    foreach ($categories as $categoryData) {
      Category::create($categoryData);
    }



  }
}