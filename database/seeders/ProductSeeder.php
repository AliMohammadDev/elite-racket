<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    $categories = Category::all();

    if ($categories->isEmpty()) {
      return;
    }

    $productsData = [
      [
        'name' => ['ar' => 'مضرب تنس احترافي', 'en' => 'Professional Tennis Racket'],
        'body' => ['ar' => 'مضرب خفيف الوزن مصنوع من الكربون', 'en' => 'Lightweight carbon fiber racket'],
      ],
      [
        'name' => ['ar' => 'كرات تنس (علبة 3 قطع)', 'en' => 'Tennis Balls (3 Pack)'],
        'body' => ['ar' => 'كرات عالية الجودة للملاعب الصلبة', 'en' => 'High-quality balls for hard courts'],
      ],
      [
        'name' => ['ar' => 'حذاء بادل رياضي', 'en' => 'Padel Sports Shoes'],
        'body' => ['ar' => 'تصميم مريح يوفر ثباتاً عالياً في الملعب', 'en' => 'Comfortable design with high court grip'],
      ],
      [
        'name' => ['ar' => 'حقيبة مضارب كبيرة', 'en' => 'Large Racket Bag'],
        'body' => ['ar' => 'تتسع لـ 6 مضارب مع جيب منفصل للأحذية', 'en' => 'Fits up to 6 rackets with separate shoe pocket'],
      ],
      [
        'name' => ['ar' => 'تيشيرت رياضي جاف', 'en' => 'Dry-Fit Sports T-Shirt'],
        'body' => ['ar' => 'قماش يسمح بالتهوية ويمتص العرق', 'en' => 'Breathable fabric with moisture-wicking technology'],
      ],
    ];

    foreach ($productsData as $item) {
      Product::create([
        'name' => $item['name'],
        'body' => $item['body'],
        'category_id' => $categories->random()->id,
      ]);
    }
  }
}
