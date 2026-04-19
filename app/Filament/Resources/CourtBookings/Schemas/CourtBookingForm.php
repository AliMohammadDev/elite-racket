<?php

namespace App\Filament\Resources\CourtBookings\Schemas;

use App\Models\Court;
use App\Models\Time;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourtBookingForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Section::make('معلومات الحجز الأساسية')
          ->schema([
            Select::make('user_id')
              ->label('المستخدم')
              ->relationship('user', 'name')
              ->searchable()
              ->preload()
              ->required(),

            Select::make('court_id')
              ->label('الملعب')
              ->relationship('court', 'id')
              ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
              ->live()
              ->afterStateUpdated(function ($state, $set, $get) {

                $court = Court::find($state);
                $times = $get('times') ?? [];
                if ($court && count($times) > 0) {
                  $set('total_price', $court->final_price * count($times));
                }
              })
              ->searchable()
              ->preload()
              ->required(),

            DatePicker::make('booking_date')
              ->label('تاريخ الحجز')
              ->native(false)
              ->displayFormat('d/m/Y')
              ->default(now())
              ->live()
              ->required(),
          ])->columns(1),

        Section::make('التوقيت والمدرب')
          ->schema([
            Select::make('times')
              ->label('الساعات المطلوبة')
              ->relationship('times', 'from')
              ->multiple()
              ->allowHtml()
              ->getOptionLabelFromRecordUsing(function ($record, $get) {
                $label =
                  Carbon::parse($record->from)->format('h:i A') . ' - ' .
                  Carbon::parse($record->to)->format('h:i A');
                $courtId = $get('court_id');
                $date = $get('booking_date');
                if (!$courtId || !$date) {
                  return $label;
                }
                $isBooked = $record->courtBookings()
                  ->where('court_id', $courtId)
                  ->whereDate('booking_date', $date)
                  ->whereIn('status', ['approved', 'pending'])
                  ->exists();
                if ($isBooked) {
                  return "<span style='color:red;font-weight:bold;'>$label (محجوز)</span>";
                }
                return $label;
              })
              ->live()
              ->preload()
              ->disableOptionWhen(function ($value, $get) {
                $courtId = $get('court_id');
                $date = $get('booking_date');
                if (!$courtId || !$date) {
                  return false;
                }
                return Time::where('id', $value)
                  ->whereHas('courtBookings', function ($query) use ($courtId, $date) {
                    $query->where('court_id', $courtId)
                      ->whereDate('booking_date', $date)
                      ->whereIn('status', ['approved', 'pending']);
                  })->exists();
              })
              ->afterStateUpdated(function ($state, $set, $get) {
                $court = Court::find($get('court_id'));
                if ($court && !empty($state)) {
                  $set('total_price', $court->final_price * count($state));
                } else {
                  $set('total_price', 0);
                }
              })
              ->required(),


            Select::make('couch_id')
              ->label('الكوتش')
              ->relationship('couch', 'id')
              ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
              ->searchable()
              ->preload()
              ->placeholder('بدون مدرب'),

            TextInput::make('total_price')
              ->label('إجمالي السعر')
              ->numeric()
              ->prefix('$')
              ->readOnly()
              ->dehydrated(true)
              ->extraAttributes(['class' => 'font-bold text-success-600']),
          ])->columns(1)

      ]);
  }
}
