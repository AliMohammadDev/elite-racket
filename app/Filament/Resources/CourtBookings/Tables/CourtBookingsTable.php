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
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class CourtBookingsTable
{
  public static function configure(Table $table): Table
  {
    $statusOptions = [
      'pending' => 'قيد الانتظار',
      'approved' => 'مقبول',
      'rejected' => 'مرفوض',
      'completed' => 'مكتمل',
    ];

    $getExcelExport = fn() => ExcelExport::make()
      ->askForFilename()
      ->withColumns([
        Column::make('user.name')
          ->heading('العميل')
          ->formatStateUsing(fn($record) => $record->user?->name),

        Column::make('user.phone')
          ->heading('رقم الهاتف')
          ->formatStateUsing(fn($record) => $record->user?->phone ?? 'غير محدد'),

        Column::make('court.translated_name')
          ->heading('الملعب')
          ->formatStateUsing(fn($record) => $record->court?->translated_name),

        Column::make('booking_date')
          ->heading('التاريخ')
          ->formatStateUsing(fn($record) => $record->booking_date?->format('d/m/Y')),

        Column::make('times_count')
          ->heading('عدد الساعات')
          ->formatStateUsing(fn($record) => $record->times_count ?? $record->times()->count()),

        Column::make('total_price')
          ->heading('الإجمالي')
          ->formatStateUsing(fn($record) => '$' . number_format($record->total_price, 2)),

        Column::make('status')
          ->heading('الحالة')
          ->formatStateUsing(fn($record) => $statusOptions[$record->status] ?? $record->status),
      ]);

    return $table
      ->columns([
        TextColumn::make('user.name')
          ->label('العميل')
          ->size(TextSize::Large)
          ->sortable()
          ->searchable(),

        TextColumn::make('user.phone')
          ->label('رقم الهاتف')
          ->size(TextSize::Large)
          ->searchable()
          ->placeholder('غير محدد'),

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
          ->options($statusOptions)
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
          ->options($statusOptions),

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
      ->headerActions([
        ExportAction::make()
          ->label('تصدير إلى إكسل')
          ->color('success')
          ->exports([$getExcelExport()]),
      ])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
          ExportBulkAction::make()
            ->label('تصدير المحدد إلى إكسل')
            ->exports([$getExcelExport()]),
        ]),
      ])
      ->defaultSort('created_at', 'desc');
  }
}
