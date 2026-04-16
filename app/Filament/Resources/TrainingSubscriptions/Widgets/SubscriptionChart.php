<?php

namespace App\Filament\Resources\TrainingSubscriptions\Widgets;

use App\Models\TrainingSubscription;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SubscriptionChart extends ChartWidget
{
  protected ?string $heading = 'Subscription Chart';

  protected int|string|array $columnSpan = 1;

  protected function getData(): array
  {
    $data = TrainingSubscription::select(
      DB::raw('COUNT(*) as count'),
      DB::raw("DATE_FORMAT(created_at, '%m') as month")
    )
      ->whereYear('created_at', date('Y'))
      ->groupBy('month')
      ->orderBy('month')
      ->pluck('count', 'month')
      ->toArray();

    $monthlyCounts = [];
    for ($i = 1; $i <= 12; $i++) {
      $monthKey = str_pad($i, 2, '0', STR_PAD_LEFT);
      $monthlyCounts[] = $data[$monthKey] ?? 0;
    }

    return [
      'datasets' => [
        [
          'label' => 'الاشتراكات الجديدة',
          'data' => $monthlyCounts,
          'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
          'borderColor' => 'rgb(54, 162, 235)',
          'borderWidth' => 2,
          'fill' => 'start',
          'tension' => 0.4,
        ],
      ],
      'labels' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
