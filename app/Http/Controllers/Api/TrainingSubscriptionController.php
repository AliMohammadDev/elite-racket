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
    $subscriptions = $this->service->findAll();
    return TrainingSubscriptionResource::collection($subscriptions);
  }

  public function store(CreateSubscriptionRequest $request)
  {
    $subscription = $this->service->create($request->validated());
    return new TrainingSubscriptionResource($subscription->load(['user', 'trainingProgram']));
  }

  public function show(TrainingSubscription $subscription)
  {
    return new TrainingSubscriptionResource($subscription);
  }

  public function update(UpdateSubscriptionRequest $request, TrainingSubscription $trainingSubscription)
  {
    $updated = $this->service->update($trainingSubscription, $request->validated());
    return new TrainingSubscriptionResource($updated->load(['user', 'trainingProgram']));
  }

  public function destroy(TrainingSubscription $trainingSubscription)
  {
    $this->service->delete($trainingSubscription);
    return response()->json(['message' => 'Subscription deleted successfully']);
  }
}
