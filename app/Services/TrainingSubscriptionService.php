<?php

namespace App\Services;

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
  public function findByUserId($userId)
  {
    return TrainingSubscription::with(['user', 'trainingProgram.couch'])
      ->where('user_id', $userId)
      ->latest()
      ->get();
  }

  public function createTrainingSubscription(array $data)
  {
    return TrainingSubscription::create($data);
  }

  public function updateTrainingSubscription(TrainingSubscription $subscription, array $data)
  {
    $subscription->update($data);
    return $subscription;
  }

  public function deleteTrainingSubscription(TrainingSubscription $subscription)
  {
    return $subscription->delete();
  }
}
