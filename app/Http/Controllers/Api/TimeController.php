<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Time\CreateTimeRequest;
use App\Http\Requests\Time\UpdateTimeRequest;
use App\Http\Resources\TimeResource;
use App\Models\Time;
use App\Services\TimeService;

class TimeController extends Controller
{
  public function __construct
  (
    private TimeService $timeService
  ) {
  }


  public function index()
  {
    $time = $this->timeService->findAll();
    return TimeResource::collection($time);
  }

  public function store(CreateTimeRequest $request)
  {
    $validated = $request->validated();
    $time = $this->timeService->createTime(
      $validated,
    );
    return new TimeResource($time);
  }

  public function show(Time $time)
  {
    return new TimeResource($time);
  }

  public function update(Time $time, UpdateTimeRequest $request)
  {
    $validated = $request->validated();

    $newTime = $this->timeService->updateTime(
      $time,
      $validated,
    );

    return new TimeResource($newTime);
  }
  public function destroy(Time $product)
  {
    $time = $this->timeService->deleteTime($product);
    return response()->json(['message' => 'Time deleted successfully']);
  }
}