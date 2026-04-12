<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Court\CreateCourtRequest;
use App\Http\Requests\Court\UpdateCourtRequest;
use App\Http\Resources\CourtResource;
use App\Models\Court;
use App\Services\CourtService;

class CourtController extends Controller
{
  public function __construct(
    private CourtService $courtService
  ) {
  }

  public function index()
  {
    return CourtResource::collection($this->courtService->findAll());
  }

  public function store(CreateCourtRequest $request)
  {
    $court = $this->courtService->create($request->validated());
    return new CourtResource($court);
  }

  public function show(Court $court)
  {
    return new CourtResource($court);
  }

  public function update(UpdateCourtRequest $request, Court $court)
  {
    $updated = $this->courtService->update($court, $request->validated());
    return new CourtResource($updated);
  }

  public function destroy(Court $court)
  {
    $this->courtService->delete($court);
    return response()->json(['message' => 'Court deleted']);
  }
}
