<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTime extends Model
{
  protected $table = 'booking_times';

  protected $fillable = [
    'time_id',
    'court_booking_id'
  ];


  public function courtBooking(): BelongsTo
  {
    return $this->belongsTo(CourtBooking::class, 'court_booking_id');
  }
}
