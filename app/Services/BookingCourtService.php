<?php

namespace App\Services;

use App\Models\BookingTime;
use App\Models\CourtBooking;
use App\Models\Time;
use Illuminate\Support\Facades\DB;

class BookingCourtService
{
  public function create(array $data)
  {
    return DB::transaction(function () use ($data) {
      $court = \App\Models\Court::find($data['court_id']);
      $timeIds = $data['time_ids'];
      $totalPrice = $court->final_price * count($timeIds);

      $booking = CourtBooking::create([
        'court_id' => $data['court_id'],
        'couch_id' => $data['couch_id'] ?? null,
        'user_id' => auth()->id(),
        'total_price' => $totalPrice,
        'booking_date' => $data['booking_date'],
        'status' => 'pending',
      ]);

      $booking->times()->attach($timeIds);
      return $booking->load(['court', 'times', 'couch']);
    });
  }

  public function getAvailableTimes(int $courtId, string $date)
  {
    $bookedTimesIds = BookingTime::whereHas('courtBooking', function ($query) use ($courtId, $date) {
      $query->where('court_id', $courtId)
        ->whereDate('booking_date', $date)
        ->whereIn('status', ['pending', 'approved']);
    })->pluck('time_id')->toArray();

    return Time::all()->map(function ($time) use ($bookedTimesIds) {
      return [
        'id' => $time->id,
        'time' => $time->from->format('H:i') . ' - ' . $time->to->format('H:i'),
        'available' => !in_array($time->id, $bookedTimesIds)
      ];
    });
  }
}
