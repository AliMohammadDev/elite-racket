<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSubscription extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'training_program_id'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function trainingProgram()
  {
    return $this->belongsTo(TrainingProgram::class, 'training_program_id');


  }
}