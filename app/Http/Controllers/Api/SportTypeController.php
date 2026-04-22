<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportType\CreateSportTypeRequest;
use App\Http\Requests\SportType\UpdateSportTypeRequest;
use App\Http\Resources\SportTypeResource;
use App\Models\SportType;
use App\Services\SportTypeService;
use Illuminate\Http\Request;

class SportTypeController extends Controller
{
  public function __construct
  (
    private SportTypeService $sportTypeService
  ) {
  }

  public function index()
  {
    $sportTypes = $this->sportTypeService->findAll();
    return SportTypeResource::collection($sportTypes);
  }

  public function store(CreateSportTypeRequest $request)
  {
    $validated = $request->validated();
    $sportType = $this->sportTypeService->createSportType(
      $validated,
    );
    return new SportTypeResource($sportType);
  }

  public function show(SportType $sportType)
  {
    return new SportTypeResource($sportType);
  }

  public function update(SportType $sportType, UpdateSportTypeRequest $request)
  {
    $validated = $request->validated();

    $newSportType = $this->sportTypeService->updateSportType(
      $sportType,
      $validated,
    );

    return new SportTypeResource($newSportType);
  }
  public function destroy(SportType $product)
  {
    $product = $this->sportTypeService->deleteSportType($product);
    return response()->json(['message' => 'Sport Type deleted successfully']);
  }
}
