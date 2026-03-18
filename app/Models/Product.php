<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'body', 'category_id'];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }


  // for ar,en
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
