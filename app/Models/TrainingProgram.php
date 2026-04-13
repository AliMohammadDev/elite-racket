<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'price', 'discounts', 'couch_id', 'train_level'];

  protected $casts = [
    'name' => 'array',
  ];

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

  public function getFinalPriceAttribute(): float
  {
    return round($this->price - ($this->price * ($this->discounts / 100)), 2);
  }


}
