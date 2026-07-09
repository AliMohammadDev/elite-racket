<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use App\Services\AiService;

class ProductForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات المنتج الأساسية')
          ->schema([
            Select::make('category_id')
              ->label('الصنف')
              ->relationship('category', 'name->ar')
              ->required()
              ->searchable()
              ->preload()
              ->columnSpanFull(),

            Grid::make(2)
              ->schema([
                TextInput::make('name.ar')
                  ->label('اسم المنتج (بالعربية)')
                  ->required(),

                TextInput::make('name.en')
                  ->label('Product Name (EN)')
                  ->required(),
              ]),

            Action::make('generateProductDescription')
              ->label('✨ توليد وصف المنتج')
              ->action(function ($get, $set) {

                $nameAr = $get('name.ar');
                $nameEn = $get('name.en');

                if (!$nameAr || !$nameEn) {
                  return;
                }

                try {

                  $data = AiService::generateProductDescription(
                    $nameAr,
                    $nameEn
                  );

                  $set('body.ar', $data['ar']);
                  $set('body.en', $data['en']);
                } catch (\Prism\Prism\Exceptions\PrismRateLimitedException $e) {

                  Notification::make()
                    ->title('تم تجاوز حد استخدام Gemini')
                    ->body('يرجى المحاولة بعد قليل.')
                    ->danger()
                    ->send();
                } catch (\Exception $e) {

                  Notification::make()
                    ->title('حدث خطأ أثناء توليد الوصف')
                    ->body('يرجى المحاولة لاحقاً.')
                    ->danger()
                    ->send();
                }
              }),


            Textarea::make('body.ar')
              ->label('وصف المنتج (بالعربية)')
              ->columnSpanFull()
              ->rows(5),


            Textarea::make('body.en')
              ->label('Product Description (EN)')
              ->columnSpanFull()
              ->rows(5),

            Toggle::make('is_featured')
              ->label('منتج مميز (Featured)')
              ->default(false)
              ->columnSpanFull(),
          ])

      ])->columns(1);
  }
}
