<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingProgram\CreateTrainingProgramRequest;
use App\Http\Requests\TrainingProgram\UpdateTrainingProgramRequest;
use App\Http\Resources\TrainingProgramResource;
use App\Models\TrainingProgram;
use App\Services\TrainingProgramService;

class TrainingProgramController extends Controller
{
  public function __construct(private TrainingProgramService $service)
  {
  }

  public function index()
  {
    $programs = $this->service->findAll();
    return TrainingProgramResource::collection($programs);
  }

  public function store(CreateTrainingProgramRequest $request)
  {
    $program = $this->service->createTrainingProgram($request->validated());
    return new TrainingProgramResource($program);
  }

  public function show(TrainingProgram $training_program)
  {
    return new TrainingProgramResource($training_program->load('couch'));
  }

  public function update(UpdateTrainingProgramRequest $request, TrainingProgram $training_program)
  {
    $updated = $this->service->updateTrainingProgram($training_program, $request->validated());
    return new TrainingProgramResource($updated);
  }

  public function destroy(TrainingProgram $trainingProgram)
  {
    $this->service->deleteTrainingProgram($trainingProgram);
    return response()->json(['message' => 'Training Program Deleted successfully']);
  }
}
