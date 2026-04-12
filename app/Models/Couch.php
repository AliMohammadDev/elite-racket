<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Couch extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'user_id', 'phone', 'address'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  protected $casts = [
    'name' => 'array',
    'address' => 'array',
  ];

  protected function translatedName(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->name[app()->getLocale()] ?? $this->name['en'] ?? '',
    );
  }

  protected function translatedAddress(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->address[app()->getLocale()] ?? $this->address['en'] ?? '',
    );
  }
}
