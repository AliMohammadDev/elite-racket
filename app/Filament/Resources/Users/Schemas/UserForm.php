<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الحساب')
          ->schema([
            Grid::make(2)->schema([
              TextInput::make('name')
                ->label('الاسم الكامل')
                ->required()
                ->maxLength(255),
              TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),
            ]),
            Grid::make(2)->schema([
              TextInput::make('password')
                ->label('كلمة المرور')
                ->password()
                ->revealable()

                ->placeholder(
                  fn(string $context): string =>
                  $context === 'edit' ? 'اتركه فارغاً للحفاظ على كلمة المرور الحالية' : ''
                )

                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state))
                ->required(fn(string $context): bool => $context === 'create')
                ->minLength(8)
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state)),

              TextInput::make('phone')
                ->label('رقم الهاتف')
                ->tel(),
            ]),
          ]),
      ])->columns(1);
  }
}
