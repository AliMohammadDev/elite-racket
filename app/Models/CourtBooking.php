<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourtBooking extends Model
{
  protected $fillable = [
    'couch_id',
    'court_id',
    'user_id',
    'total_price',
    'status',
    'booking_date',
  ];


  protected $casts = [
    'booking_date' => 'date',
    'total_price' => 'decimal:2',
  ];

  public function court()
  {
    return $this->belongsTo(Court::class);
  }
  public function couch()
  {
    return $this->belongsTo(Couch::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function times(): BelongsToMany
  {
    return $this->belongsToMany(Time::class, 'booking_times');
  }

}
