<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use App\Services\AiService;
use Filament\Notifications\Notification;

class CategoryForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('Basic Information')
          ->schema([
            TextInput::make('name.ar')
              ->label('الاسم بالعربية')
              ->required(),

            TextInput::make('name.en')
              ->label('Name in English')
              ->required(),

            Action::make('generateDescription')
              ->label('✨ توليد الوصف')
              ->action(function ($get, $set) {

                $name = $get('name.ar');

                if (! $name) {
                  return;
                }

                try {

                  $data = AiService::generateCategoryDescription($name);

                  $set('description.ar', $data['ar']);
                  $set('description.en', $data['en']);
                } catch (\Prism\Prism\Exceptions\PrismRateLimitedException $e) {

                  Notification::make()
                    ->title('تم تجاوز حد استخدام Gemini')
                    ->body('يرجى المحاولة  لاحقا.')
                    ->danger()
                    ->send();
                } catch (\Exception $e) {

                  Notification::make()
                    ->title('حدث خطأ أثناء توليد الوصف')
                    ->body($e->getMessage())
                    ->danger()
                    ->send();
                }
              }),

            Textarea::make('description.ar')
              ->label('الوصف بالعربية')
              ->rows(5),

            Textarea::make('description.en')
              ->label('Description in English')
              ->rows(5),

          ])
          ->columns(1),

        Section::make('الصور')
          ->schema([
            SpatieMediaLibraryFileUpload::make('image')
              ->collection('categories')
              ->disk('public')
              ->image()
              ->multiple()
              ->reorderable()
              ->columnSpanFull(),
          ]),
      ])->columns(1);
  }
}
