<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class UserInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات المستخدم الشخصية')
          ->icon('heroicon-o-user')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('name')
                  ->size(TextSize::Large)
                  ->label('الاسم الكامل'),
                TextEntry::make('email')
                  ->label('البريد الإلكتروني')
                  ->icon('heroicon-m-envelope')
                  ->size(TextSize::Large)
                  ->copyable()
                  ->color('primary'),

                TextEntry::make('phone')
                  ->label('رقم الهاتف')
                  ->icon('heroicon-m-phone')
                  ->size(TextSize::Large)
                  ->copyable(),
              ]),
          ]),

        Grid::make(2)
          ->schema([
            Section::make('حالة الحساب والتوثيق')
              ->icon('heroicon-o-shield-check')
              ->schema([
                Grid::make(2)
                  ->schema([
                    IconEntry::make('is_active')
                      ->label('الحساب نشط')
                      ->boolean(),
                    TextEntry::make('email_verified_at')
                      ->label('تاريخ التوثيق')
                      ->dateTime()
                      ->placeholder('لم يوثق بعد')
                      ->visible(fn($record) => filled($record->email_verified_at)),
                  ]),
              ])->columnSpan(1),
          ]),

        Section::make('معلومات إضافية')
          ->schema([
            Grid::make(2)
              ->schema([
                TextEntry::make('created_at')
                  ->label('تاريخ الإنشاء')
                  ->dateTime()
                  ->badge()
                  ->size(TextSize::Large)
                  ->color('success')
                  ->extraAttributes([
                    'class' => 'rounded-full px-4 py-2 text-center'
                  ]),

                TextEntry::make('updated_at')
                  ->label('آخر تحديث')
                  ->dateTime()
                  ->badge()
                  ->size(TextSize::Large)
                  ->color('info')
                  ->extraAttributes([
                    'class' => 'rounded-full px-4 py-2 text-center'
                  ]),
              ])
              ->gap(4),
          ])

      ]);
  }
}
