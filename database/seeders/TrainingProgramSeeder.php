<?php

namespace Database\Seeders;

use App\Models\Couch;
use App\Models\SportType;
use App\Models\TrainingProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TrainingProgramSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $couches = Couch::all();
    $sportTypes = SportType::all();

    if ($couches->isEmpty()) {
      $this->command->warn('يرجى تشغيل CouchSeeder أولاً!');
      return;
    }

    $trainingImages = [
      'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?q=80&w=1000&auto=format&fit=crop',
      'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?q=80&w=1000&auto=format&fit=crop',
      'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?q=80&w=1000&auto=format&fit=crop',
      'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1000&auto=format&fit=crop',
      'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1000&auto=format&fit=crop',
    ];

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
          'users_count' => rand(10, 15),
        ],
        [
          'name' => [
            'ar' => "تطوير المهارات المتوسطة مع $couchNameAr",
            'en' => "Intermediate Skills with $couchNameEn"
          ],
          'price' => 550.00,
          'discounts' => 50.00,
          'train_level' => 'intermediate',
          'users_count' => rand(15, 25),
        ],
        [
          'name' => [
            'ar' => "إعداد البطولات والمحترفين ($couchNameAr)",
            'en' => "Pro Tournament Prep ($couchNameEn)"
          ],
          'price' => 900.00,
          'discounts' => 100.00,
          'train_level' => 'advanced',
          'users_count' => 8,
        ],
      ];

      foreach ($programs as $programData) {
        $startDate = Carbon::now()->addDays(rand(1, 10));
        $endDate = (clone $startDate)->addMonths(rand(1, 3));

        $randomSportType = $sportTypes->random();

        $program = TrainingProgram::create([
          'name' => $programData['name'],
          'sport_type_id' => $randomSportType->id,
          'price' => $programData['price'],
          'discounts' => $programData['discounts'],
          'couch_id' => $couch->id,
          'train_level' => $programData['train_level'],
          'users_count' => $programData['users_count'],
          'start_date' => $startDate,
          'end_date' => $endDate,
        ]);

        try {
          $program->addMediaFromUrl($trainingImages[array_rand($trainingImages)])
            ->toMediaCollection('training_programs');
        } catch (\Exception $e) {
          continue;
        }
      }
    }
  }
}
