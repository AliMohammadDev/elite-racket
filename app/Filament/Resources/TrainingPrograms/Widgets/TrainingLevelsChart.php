<?php

namespace App\Filament\Resources\TrainingPrograms\Widgets;

use App\Models\TrainingProgram;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TrainingLevelsChart extends ChartWidget
{
  protected ?string $heading = 'توزيع مستويات التدريب';

  protected int|string|array $columnSpan = 1;

  protected ?string $maxHeight = '365px';

  protected function getData(): array
  {
    $data = TrainingProgram::select('train_level', DB::raw('count(*) as total'))
      ->groupBy('train_level')
      ->pluck('total', 'train_level')
      ->toArray();

    return [
      'datasets' => [
        [
          'label' => 'المستويات',
          'data' => [
            $data['beginner'] ?? 0,
            $data['intermediate'] ?? 0,
            $data['advanced'] ?? 0,
          ],
          'backgroundColor' => [
            '#22c55e',
            '#f59e0b',
            '#ef4444',
          ],
        ],
      ],
      'labels' => ['🌱 مبتدئ', '⚡ متوسط', '🔥 متقدم'],
    ];
  }

  protected function getType(): string
  {
    return 'doughnut';
  }
}
