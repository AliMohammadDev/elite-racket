<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportType extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'body',
  ];

  protected $casts = [
    'name' => 'array',
    'body' => 'array',
  ];

  public function getTranslatedNameAttribute(): string
  {
    return $this->name[app()->getLocale()] ?? $this->name['en'] ?? '';
  }

  public function getTranslatedBodyAttribute(): string
  {
    return $this->body[app()->getLocale()] ?? $this->body['en'] ?? '';
  }


}
