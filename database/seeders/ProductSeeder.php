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
        'name' => ['ar' => 'مضرب تنس Wilson Pro Staff', 'en' => 'Wilson Pro Staff Racket'],
        'body' => ['ar' => 'مضرب كلاسيكي يوفر دقة متناهية للاعبين المحترفين.', 'en' => 'Classic racket providing ultimate precision for pro players.'],
      ],
      [
        'name' => ['ar' => 'مضرب بادل Babolat Technical Viper', 'en' => 'Babolat Technical Viper Padel'],
        'body' => ['ar' => 'مضرب ذو قوة انفجارية مصمم للهجوم السريع.', 'en' => 'Explosive power racket designed for quick attacks.'],
      ],
      [
        'name' => ['ar' => 'مضرب تنس للأطفال (Head Junior)', 'en' => 'Head Junior Tennis Racket'],
        'body' => ['ar' => 'خفيف الوزن وسهل التحكم، مثالي للمبتدئين الصغار.', 'en' => 'Lightweight and easy to handle, perfect for young beginners.'],
      ],

      [
        'name' => ['ar' => 'كرات تنس Wilson (علبة 4 قطع)', 'en' => 'Wilson Tennis Balls (4 Pack)'],
        'body' => ['ar' => 'الكرة الرسمية لأكبر البطولات العالمية.', 'en' => 'The official ball for major world championships.'],
      ],
      [
        'name' => ['ar' => 'كرات بادل Bullpadel Premium Pro', 'en' => 'Bullpadel Premium Pro Balls'],
        'body' => ['ar' => 'سرعة عالية ومتانة تدوم طويلاً في الملاعب.', 'en' => 'High speed and long-lasting durability on court.'],
      ],

      [
        'name' => ['ar' => 'حذاء ASICS Gel-Resolution 9', 'en' => 'ASICS Gel-Resolution 9 Shoes'],
        'body' => ['ar' => 'يوفر ثباتاً ممتازاً وحماية للقدم أثناء الحركات الجانبية.', 'en' => 'Provides excellent stability and foot protection during lateral moves.'],
      ],
      [
        'name' => ['ar' => 'تيشيرت Nike Court Advantage', 'en' => 'Nike Court Advantage T-Shirt'],
        'body' => ['ar' => 'تقنية Dry-Fit المتقدمة للحفاظ على الجفاف.', 'en' => 'Advanced Dry-Fit technology to keep you dry.'],
      ],
      [
        'name' => ['ar' => 'شورت بادل تقني', 'en' => 'Technical Padel Shorts'],
        'body' => ['ar' => 'مرونة كاملة في الحركة مع جيوب مخصصة للكرات.', 'en' => 'Full freedom of movement with dedicated ball pockets.'],
      ],

      [
        'name' => ['ar' => 'حقيبة مضارب Yonex (9 قطع)', 'en' => 'Yonex Racket Bag (9 Pack)'],
        'body' => ['ar' => 'مساحة تخزين واسعة مع حماية حرارية للمضارب.', 'en' => 'Spacious storage with thermal protection for rackets.'],
      ],
      [
        'name' => ['ar' => 'قبضة مضرب (Overgrip) حزمة 3', 'en' => 'Overgrip 3-Pack'],
        'body' => ['ar' => 'امتصاص عالي للعرق وتوفير قبضة قوية ومنعشة.', 'en' => 'High sweat absorption providing a firm and fresh grip.'],
      ],
      [
        'name' => ['ar' => 'ساعة تتبع أداء رياضية', 'en' => 'Sports Performance Tracker Watch'],
        'body' => ['ar' => 'تتبع نبضات القلب والسعرات الحرارية أثناء المباراة.', 'en' => 'Track heart rate and calories during the match.'],
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