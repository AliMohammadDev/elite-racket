<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Lang;

class OrdersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('user.name')
          ->label('العميل')
          ->size(TextSize::Large)
          ->weight('bold')
          ->searchable()
          ->sortable(),

        TextColumn::make('user.phone')
          ->label('رقم الهاتف')
          ->size(TextSize::Large)
          ->icon('heroicon-o-phone'),

        TextColumn::make('total_price')
          ->label('الإجمالي')
          ->formatStateUsing(fn($state) => $state . ' USD')
          ->size(TextSize::Large)
          ->weight('medium')
          ->sortable(),

        TextColumn::make('status')
          ->label('الحالة')
          ->badge()
          ->size(TextSize::Medium)
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
          }),

        TextColumn::make('created_at')
          ->label('تاريخ الطلب')
          ->dateTime()
          ->size(TextSize::Large)
          ->sortable(),
      ])
      ->filters([
        SelectFilter::make('status')
          ->label('فلترة حسب الحالة')
          ->options([
            'pending' => 'قيد الانتظار',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
          ]),
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


    // ->actions([
    //   ActionGroup::make([
    //     ViewAction::make(),
    //     EditAction::make(),
    //     DeleteAction::make(),
    //   ]),
    // ]);
  }
}
