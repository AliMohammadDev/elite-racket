<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    $tennisCategory = Category::where('name->en', 'Tennis Equipment')->first();
    $apparelCategory = Category::where('name->en', 'Sports Apparel')->first();
    $shoesCategory = Category::where('name->en', 'Sports Shoes')->first();
    $padelCategory = Category::where('name->en', 'Padel Equipment')->first();

    if (!$tennisCategory || !$apparelCategory || !$shoesCategory || !$padelCategory) {
      return;
    }

    $productsData = [
      [
        'category_id' => $tennisCategory->id,
        'name' => ['ar' => 'مضرب تنس Wilson Pro Staff', 'en' => 'Wilson Pro Staff Racket'],
        'body' => ['ar' => 'مضرب كلاسيكي يوفر دقة متناهية للاعبين المحترفين.', 'en' => 'Classic racket providing ultimate precision for pro players.'],
      ],
      [
        'category_id' => $tennisCategory->id,
        'name' => ['ar' => 'مضرب تنس Babolat Pure Drive', 'en' => 'Babolat Pure Drive Racket'],
        'body' => ['ar' => 'يوفر قوة هائلة وتحكمًا ممتازًا في كل ضربة.', 'en' => 'Delivers explosive power and superior playability on every shot.'],
      ],
      [
        'category_id' => $tennisCategory->id,
        'name' => ['ar' => 'علبة كرات تنس Wilson Championship (4 قطع)', 'en' => 'Wilson Championship Tennis Balls (4 Pack)'],
        'body' => ['ar' => 'الكرة الرسمية المصممة لتدريبات ومباريات التحمل العالي.', 'en' => 'Official ball designed for high-end practice and matches.'],
      ],

      [
        'category_id' => $apparelCategory->id,
        'name' => ['ar' => 'تيشيرت Nike Court Advantage', 'en' => 'Nike Court Advantage T-Shirt'],
        'body' => ['ar' => 'تقنية Dry-Fit المتقدمة للحفاظ على الجفاف والراحة طوال المباراة.', 'en' => 'Advanced Dry-Fit technology to keep you dry and comfortable during matches.'],
      ],
      [
        'category_id' => $apparelCategory->id,
        'name' => ['ar' => 'شورت بادل وتنس تقني من Adidas', 'en' => 'Adidas Club Tennis Shorts'],
        'body' => ['ar' => 'مرونة كاملة في الحركة مع خصر مطاطي وجيوب عميقة للكرات.', 'en' => 'Full freedom of movement with an elastic waistband and deep ball pockets.'],
      ],
      [
        'category_id' => $apparelCategory->id,
        'name' => ['ar' => 'جاكيت رياضية خفيفة الوزن', 'en' => 'Lightweight Performance Sports Jacket'],
        'body' => ['ar' => 'مصممة خصيصاً لعمليات الإحماء والأجواء الباردة.', 'en' => 'Specially designed for warm-ups and cooler weather conditions.'],
      ],

      [
        'category_id' => $shoesCategory->id,
        'name' => ['ar' => 'حذاء ASICS Gel-Resolution 9', 'en' => 'ASICS Gel-Resolution 9 Shoes'],
        'body' => ['ar' => 'يوفر ثباتاً ممتازاً وحماية للقدم أثناء الحركات الجانبية السريعة.', 'en' => 'Provides excellent stability and foot protection during fast lateral movements.'],
      ],
      [
        'category_id' => $shoesCategory->id,
        'name' => ['ar' => 'حذاء Adidas Barricade للملاعب', 'en' => 'Adidas Barricade Court Shoes'],
        'body' => ['ar' => 'متانة عالية وتصميم مريح مصمم خصيصاً لملاعب التنس والبادل.', 'en' => 'High durability and comfortable design tailored for tennis and padel courts.'],
      ],
      [
        'category_id' => $shoesCategory->id,
        'name' => ['ar' => 'حذاء Nike Court Vapor Lite', 'en' => 'Nike Court Vapor Lite Shoes'],
        'body' => ['ar' => 'خفيف الوزن للغاية لسرعة استجابة فائقة على أرضية الملعب.', 'en' => 'Ultra-lightweight design for maximum responsiveness on the court.'],
      ],

      [
        'category_id' => $padelCategory->id,
        'name' => ['ar' => 'مضرب بادل Babolat Technical Viper', 'en' => 'Babolat Technical Viper Padel'],
        'body' => ['ar' => 'مضرب ذو قوة انفجارية مصمم للهجوم السريع والضربات القاضية.', 'en' => 'Explosive power padel racket designed for rapid attacks and smashes.'],
      ],
      [
        'category_id' => $padelCategory->id,
        'name' => ['ar' => 'مضرب بادل Bullpadel Hack 03', 'en' => 'Bullpadel Hack 03 Padel Racket'],
        'body' => ['ar' => 'مضرب احترافي يجمع بين القوة المطلقة والتحكم الاستثنائي.', 'en' => 'Pro racket combining absolute power and exceptional control.'],
      ],
      [
        'category_id' => $padelCategory->id,
        'name' => ['ar' => 'كرات بادل Bullpadel Premium Pro (علبة 3)', 'en' => 'Bullpadel Premium Pro Padel Balls (3 Pack)'],
        'body' => ['ar' => 'سرعة عالية وعمر افتراضي طويل مصممة خصيصاً لملاعب البادل.', 'en' => 'High speed and long durability specifically engineered for padel courts.'],
      ],
    ];

    foreach ($productsData as $productData) {
      Product::create($productData);
    }
  }
}
