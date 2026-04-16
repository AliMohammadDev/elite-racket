<?php

namespace Database\Seeders;

use App\Models\TrainingProgram;
use App\Models\TrainingSubscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TrainingSubscriptionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = User::role('customer')->get();
    $programs = TrainingProgram::all();


    for ($i = 0; $i < 50; $i++) {
      $user = $users->random();
      $program = $programs->random();

      $randomDate = Carbon::now()
        ->startOfYear()
        ->addDays(rand(0, Carbon::now()->dayOfYear));

      TrainingSubscription::create([
        'user_id' => $user->id,
        'training_program_id' => $program->id,
        'created_at' => $randomDate,
        'updated_at' => $randomDate,
      ]);
    }
  }
}