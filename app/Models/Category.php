<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'description'];

  protected $casts = [
    'name' => 'array',
    'description' => 'array',
  ];

  public function getTranslatedNameAttribute(): string
  {
    return $this->name[app()->getLocale()]
      ?? $this->name['en']
      ?? '';
  }

  public function getTranslatedDescriptionAttribute(): string
  {
    return $this->description[app()->getLocale()]
      ?? $this->description['en']
      ?? '';
  }
}
