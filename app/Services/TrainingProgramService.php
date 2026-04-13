<?php

namespace App\Services;

use App\Models\TrainingProgram;

class TrainingProgramService
{
  public function findAll()
  {
    return TrainingProgram::with('couch')
      ->latest()
      ->get();
  }

  public function createTrainingProgram(array $data)
  {
    return TrainingProgram::create($data);
  }

  public function updateTrainingProgram(TrainingProgram $program, array $data)
  {
    $program->update($data);
    return $program;
  }

  public function deleteTrainingProgram(TrainingProgram $program)
  {
    return $program->delete();
  }
}
