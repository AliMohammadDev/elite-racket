<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
  protected $fillable = ['from', 'to'];

  protected $casts = [
    'from' => 'datetime:H:i',
    'to' => 'datetime:H:i',
  ];
}