<?php

namespace Database\Seeders;

use App\Models\Time;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TimeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $startTime = Carbon::createFromTime(6, 0, 0);
    $endTime = Carbon::createFromTime(23, 0, 0);

    while ($startTime->lessThanOrEqualTo($endTime)) {
      Time::create([
        'from' => $startTime->format('H:i:s'),
        'to' => $startTime->copy()->addHour()->format('H:i:s'),
      ]);

      $startTime->addHour();
    }
  }
}
