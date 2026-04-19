<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingTime extends Model
{
  protected $table = 'booking_times';

  protected $fillable = [
    'time_id',
    'court_booking_id'
  ];
}
