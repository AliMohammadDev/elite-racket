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
            'ar' => "دورة المبتدئين مع $couchNameAr",
            'en' => "Beginner Course with $couchNameEn"
          ],
          'price' => 300.0,
          'discounts' => 0.0,
          'train_level' => 'beginner',
        ],
        [
          'name' => [
            'ar' => "برنامج التدريب المكثف - $couchNameAr",
            'en' => "Intensive Training - $couchNameEn"
          ],
          'price' => 500.0,
          'discounts' => 10.0,
          'train_level' => 'intermediate',
        ],
        [
          'name' => [
            'ar' => "كورس المحترفين والبطولات ($couchNameAr)",
            'en' => "Pro & Tournament Course ($couchNameEn)"
          ],
          'price' => 850.0,
          'discounts' => 15.0,
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