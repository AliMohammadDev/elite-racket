<?php

namespace App\Filament\Resources\CourtBookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourtBookingsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('user.name')
          ->label('العميل')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        TextColumn::make('court.translated_name')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable()
          ->label('الملعب'),

        TextColumn::make('booking_date')
          ->label('التاريخ')
          ->date()
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        TextColumn::make('times_count')
          ->label('عدد الساعات')
          ->counts('times')
          ->badge()
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        TextColumn::make('total_price')
          ->label('الإجمالي')
          ->money('USD', locale: 'en')
          ->color('success')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        SelectColumn::make('status')
          ->label('الحالة')
          ->sortable()
          ->searchable()
          ->options([
            'pending' => 'قيد الانتظار',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            'completed' => 'مكتمل',
          ])
          ->selectablePlaceholder(false)
          ->extraAttributes(fn($state) => [
            'style' => match ($state) {
              'approved' => 'color: green; font-weight: bold;',
              'pending' => 'color: orange; font-weight: bold;',
              'rejected' => 'color: red; font-weight: bold;',
              'completed' => 'color: blue; font-weight: bold;',
              default => '',
            }
          ])

      ])
      ->filters([
        SelectFilter::make('status')
          ->label('حالة الحجز')
          ->options([
            'pending' => 'قيد الانتظار',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            'completed' => 'مكتمل',
          ]),

        SelectFilter::make('court_id')
          ->label('الملعب')
          ->relationship('court', 'id')
          ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
          ->searchable()
          ->preload(),

        SelectFilter::make('booking_date')
          ->label('تاريخ الحجز')
          ->schema([
            DatePicker::make('from')
              ->label('من تاريخ'),
            DatePicker::make('to')
              ->label('إلى تاريخ'),
          ])
          ->query(function (Builder $query, array $data): Builder {
            return $query
              ->when(
                $data['from'],
                fn(Builder $query, $date): Builder => $query->whereDate('booking_date', '>=', $date),
              )
              ->when(
                $data['to'],
                fn(Builder $query, $date): Builder => $query->whereDate('booking_date', '<=', $date),
              );
          })
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ])->defaultSort('created_at', 'desc');
  }
}
