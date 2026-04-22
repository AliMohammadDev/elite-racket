<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Time extends Model
{
  protected $fillable = ['from', 'to'];

  protected $casts = [
    'from' => 'datetime:H:i',
    'to' => 'datetime:H:i',
  ];

  public function courtBookings(): BelongsToMany
  {
    return $this->belongsToMany(CourtBooking::class, 'booking_times');
  }
}
