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
  public function __construct(
    private TrainingProgramService $trainingProgramService
  ) {
  }

  public function index()
  {
    $programs = $this->trainingProgramService->findAll();
    return TrainingProgramResource::collection($programs);
  }

  public function store(CreateTrainingProgramRequest $request)
  {
    $validated = $request->validated();

    $program = $this->trainingProgramService->createTrainingProgram(
      $validated,
      $request->file('image')
    );
    return new TrainingProgramResource($program);
  }

  public function show(TrainingProgram $training_program)
  {
    return new TrainingProgramResource($training_program->load('couch'));
  }

  public function update(UpdateTrainingProgramRequest $request, TrainingProgram $training_program)
  {

    $validated = $request->validated();
    $newTrainingProgram = $this->trainingProgramService->updateTrainingProgram(
      $training_program,
      $validated,
      $request->file('image')
    );


    return new TrainingProgramResource($newTrainingProgram);
  }

  public function destroy(TrainingProgram $trainingProgram)
  {
    $this->trainingProgramService->deleteTrainingProgram($trainingProgram);
    return response()->json(['message' => 'Training Program Deleted successfully']);
  }
}
