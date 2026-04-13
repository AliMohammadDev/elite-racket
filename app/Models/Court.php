<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'price', 'discounts'];

  protected function finalPrice(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->price - ($this->price * ($this->discounts / 100)),
    );
  }

  protected $casts = [
    'name' => 'array',
  ];

  protected function translatedName(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->name[app()->getLocale()] ?? $this->name['en'] ?? '',
    );
  }


}