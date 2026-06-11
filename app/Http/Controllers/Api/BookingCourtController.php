<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingCourt\CreateBookingCourtRequest;
use App\Http\Resources\BookingCourtResource;
use App\Services\BookingCourtService;
use Illuminate\Http\Request;

class BookingCourtController extends Controller
{
  public function __construct(
    private BookingCourtService $bookingCourtService
  ) {}

  public function store(CreateBookingCourtRequest $request)
  {
    $booking = $this->bookingCourtService->create($request->validated());
    return new BookingCourtResource($booking);
  }

  public function getAvailableTimes(Request $request)
  {
    $validated = $request->validate([
      'court_id' => 'required|exists:courts,id',
      'date'     => 'required|date',
    ]);

    $times = $this->bookingCourtService->getAvailableTimes(
      $validated['court_id'],
      $validated['date']
    );

    return response()->json($times);
  }
}
