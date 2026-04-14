<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        SpatieMediaLibraryImageColumn::make('image')
          ->collection('categories')
          ->label('Image')
          ->circular(),
        TextColumn::make('name.ar')
          ->searchable()
          ->sortable(),

        TextColumn::make('name.en')
          ->label('Name (EN)')
          ->searchable()
          ->sortable(),
        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
      ])
      ->filters([
        Filter::make('created_at')
          ->form([
            DatePicker::make('created_from')->label('أنشئ من تاريخ'),
            DatePicker::make('created_until')->label('أنشئ إلى تاريخ'),
          ])
          ->query(function (Builder $query, array $data): Builder {
            return $query
              ->when(
                $data['created_from'],
                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
              )
              ->when(
                $data['created_until'],
                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
              );
          })
          ->indicateUsing(function (array $data): array {
            $indicators = [];
            if ($data['created_from'] ?? null) {
              $indicators[] = 'من تاريخ: ' . $data['created_from'];
            }
            if ($data['created_until'] ?? null) {
              $indicators[] = 'إلى تاريخ: ' . $data['created_until'];
            }
            return $indicators;
          }),
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}