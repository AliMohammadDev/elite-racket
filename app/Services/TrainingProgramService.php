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

  public function create(array $data)
  {
    return TrainingProgram::create($data);
  }

  public function update(TrainingProgram $program, array $data)
  {
    $program->update($data);
    return $program;
  }

  public function delete(TrainingProgram $program)
  {
    return $program->delete();
  }
}
