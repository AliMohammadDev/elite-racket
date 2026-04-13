<?php

namespace App\Services;

use App\Models\TrainingProgram;
use App\Models\TrainingSubscription;

class TrainingSubscriptionService
{
  public function findAll()
  {
    return TrainingSubscription::with(['user', 'trainingProgram.couch'])
      ->latest()->get();
  }

  public function findById($id)
  {
    return TrainingSubscription::with(['user', 'trainingProgram.couch'])->findOrFail($id);
  }

  public function create(array $data)
  {
    return TrainingSubscription::create($data);
  }

  public function update(TrainingSubscription $subscription, array $data)
  {
    $subscription->update($data);
    return $subscription;
  }

  public function delete(TrainingSubscription $subscription)
  {
    return $subscription->delete();
  }
}
