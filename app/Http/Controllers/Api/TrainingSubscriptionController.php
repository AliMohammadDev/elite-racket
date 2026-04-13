<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingSubscription\CreateSubscriptionRequest;
use App\Http\Requests\TrainingSubscription\UpdateSubscriptionRequest;
use App\Http\Resources\TrainingSubscriptionResource;
use App\Services\TrainingSubscriptionService;
use App\Models\TrainingSubscription;

class TrainingSubscriptionController extends Controller
{
  public function __construct(private TrainingSubscriptionService $service)
  {
  }
  public function index()
  {
    if (request()->is('*my-subscriptions')) {
      $subscriptions = $this->service->findByUserId(auth()->id());
    } else {
      $subscriptions = $this->service->findAll();
    }

    return TrainingSubscriptionResource::collection($subscriptions);
  }
  public function store(CreateSubscriptionRequest $request)
  {
    $subscription = $this->service->createTrainingSubscription($request->validated());
    return new TrainingSubscriptionResource($subscription->load(['user', 'trainingProgram']));
  }

  public function show(TrainingSubscription $all_subscription)
  {
    return new TrainingSubscriptionResource($all_subscription);
  }

  public function update(UpdateSubscriptionRequest $request, TrainingSubscription $all_subscription)
  {
    $updated = $this->service->updateTrainingSubscription($all_subscription, $request->validated());
    return new TrainingSubscriptionResource($updated->load(['user', 'trainingProgram']));
  }

  public function destroy(TrainingSubscription $trainingSubscription)
  {
    $this->service->deleteTrainingSubscription($trainingSubscription);
    return response()->json(['message' => 'Subscription deleted successfully']);
  }
}
