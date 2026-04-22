<?php

namespace Database\Seeders;

use App\Models\SportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $sportTypes = [
      [
        'name' => [
          'ar' => 'تنس (كرة المضرب)',
          'en' => 'Tennis'
        ],
        'body' => [
          'ar' => 'رياضة تُلعب في ملاعب عشبية، ترابية أو صلبة باستخدام مضارب وكرة صفراء.',
          'en' => 'A sport played on grass, clay, or hard courts using rackets and a yellow ball.'
        ],
      ],
      [
        'name' => [
          'ar' => 'بادل',
          'en' => 'Padel'
        ],
        'body' => [
          'ar' => 'رياضة مشتقة من التنس، تُلعب في ملعب محاط بزجاج وتمتاز بالسرعة والمتعة.',
          'en' => 'A racket sport derived from tennis, played in an enclosed court with glass walls.'
        ],
      ],
      [
        'name' => [
          'ar' => 'راكيت',
          'en' => 'Racket'
        ],
        'body' => [
          'ar' => 'تشمل مجموعة من الرياضات التي تعتمد على المضرب مثل السكواش والريشة الطائرة.',
          'en' => 'Includes a variety of sports that depend on rackets, such as squash and badminton.'
        ],
      ],
    ];

    foreach ($sportTypes as $type) {
      SportType::create($type);
    }
  }
}