<?php

namespace App\Models;

use App\MediaLibrary\TrainingProgramPathGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

class TrainingProgram extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;

  protected $fillable = [
    'name',
    'sport_type_id',
    'price',
    'discounts',
    'couch_id',
    'train_level',
    'start_date',
    'end_date',
    'users_count'
  ];

  protected $casts = [
    'name' => 'array',
  ];


  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      TrainingProgramPathGenerator::class
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

  public function subscriptions()
  {
    return $this->hasMany(TrainingSubscription::class);
  }

  public function getRemainingSlotsAttribute(): int
  {
    return max(0, $this->users_count - $this->subscriptions()->count());
  }

  public function sportType()
  {
    return $this->belongsTo(SportType::class);
  }

  public function couch()
  {
    return $this->belongsTo(Couch::class);
  }

  protected function finalPrice(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->price - ($this->price * ($this->discounts / 100)),
    );
  }

  public function getTranslatedNameAttribute(): string
  {
    return $this->name[app()->getLocale()] ?? $this->name['en'] ?? '';
  }



}
