<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
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


  public function subscriptions()
  {
    return $this->hasMany(TrainingSubscription::class);
  }

  public function getRemainingSlotsAttribute(): int
  {
    return max(0, $this->users_count - $this->subscriptions()->count());
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
