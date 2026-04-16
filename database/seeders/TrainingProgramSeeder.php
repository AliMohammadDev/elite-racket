<?php

namespace Database\Seeders;

use App\Models\Couch;
use App\Models\TrainingProgram;
use Illuminate\Database\Seeder;

class TrainingProgramSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $couches = Couch::all();

    foreach ($couches as $couch) {
      $couchNameAr = $couch->name['ar'] ?? 'المدرب';
      $couchNameEn = $couch->name['en'] ?? 'Coach';

      $programs = [
        [
          'name' => [
            'ar' => "أساسيات التنس للمبتدئين - $couchNameAr",
            'en' => "Tennis Basics for Beginners - $couchNameEn"
          ],
          'price' => 300.00,
          'discounts' => 0.00,
          'train_level' => 'beginner',
        ],
        [
          'name' => [
            'ar' => "تطوير المهارات المتوسطة مع $couchNameAr",
            'en' => "Intermediate Skills with $couchNameEn"
          ],
          'price' => 550.00,
          'discounts' => 50.00,
          'train_level' => 'intermediate',
        ],
        [
          'name' => [
            'ar' => "إعداد البطولات والمحترفين ($couchNameAr)",
            'en' => "Pro Tournament Prep ($couchNameEn)"
          ],
          'price' => 900.00,
          'discounts' => 100.00,
          'train_level' => 'advanced',
        ],
      ];

      foreach ($programs as $programData) {
        TrainingProgram::create([
          'name' => $programData['name'],
          'price' => $programData['price'],
          'discounts' => $programData['discounts'],
          'couch_id' => $couch->id,
          'train_level' => $programData['train_level'],
        ]);
      }
    }

  }
}