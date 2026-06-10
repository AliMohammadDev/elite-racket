<?php

namespace App\Models;

use App\MediaLibrary\CourtPathGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

class Court extends Model implements HasMedia
{

  use HasFactory, InteractsWithMedia;
  protected $fillable = ['name', 'price', 'discounts'];


  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      CourtPathGenerator::class
    );
  }

  public function registerMediaConversions(?Media $media = null): void
  {
    $this->addMediaConversion('default')
      ->fit(Fit::Max, 1000, 1000)
      ->quality(70)
      ->format('webp')
      ->nonQueued();
  }



  protected function finalPrice(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->price - ($this->price * ($this->discounts / 100)),
    );
  }

  protected $casts = [
    'name' => 'array',
    'price' => 'double',
    'discounts' => 'double',
  ];

  protected function translatedName(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->name[app()->getLocale()] ?? $this->name['en'] ?? '',
    );
  }

  public function bookings()
  {
    return $this->hasMany(CourtBooking::class);
  }
}
