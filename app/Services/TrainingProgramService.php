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

  public function createTrainingProgram(array $data, $imageFile = null)
  {
    $trainingProgram = TrainingProgram::create($data);
    if ($imageFile) {
      $trainingProgram->addMedia($imageFile)->toMediaCollection('training_programs');
    }
    return $trainingProgram;
  }

  public function updateTrainingProgram(TrainingProgram $training_program, array $data, $imageFile = null)
  {
    $training_program->update($data);
    if ($imageFile) {
      $training_program->clearMediaCollection('training_programs');
      $training_program->addMedia($imageFile)->toMediaCollection('training_programs');
    }
    return $training_program;
  }

  public function deleteTrainingProgram(TrainingProgram $program)
  {
    return $program->delete();
  }
}
