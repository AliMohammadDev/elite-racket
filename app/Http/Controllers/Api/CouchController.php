<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couch\CreateCouchRequest;
use App\Http\Requests\Couch\UpdateCouchRequest;
use App\Http\Resources\CouchResource;
use App\Models\Couch;
use App\Services\CouchService;

class CouchController extends Controller
{
  public function __construct
  (
    private CouchService $couchService
  ) {
  }

  public function index()
  {
    $categories = $this->couchService->findAll();
    return CouchResource::collection($categories);
  }

  public function store(CreateCouchRequest $request)
  {
    $color = $this->couchService->createCouch($request->validated());
    return new CouchResource($color);
  }

  public function show(Couch $couch)
  {
    return new CouchResource($couch);
  }

  public function update(Couch $couch, UpdateCouchRequest $request)
  {
    $newCooch = $this->couchService->updateCouch($couch, $request->validated());
    return new CouchResource($newCooch);
  }
  public function destroy(Couch $couch)
  {
    $couch = $this->couchService->deleteCouch($couch);
    return response()->json(['message' => 'Couch deleted successfully']);
  }

}