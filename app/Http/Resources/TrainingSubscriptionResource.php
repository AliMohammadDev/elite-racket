<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingSubscriptionResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'subscription_price' => $this->trainingProgram->final_price,
      'user_name' => $this->user->name,
      'program_details' => [
        'id' => $this->trainingProgram->id,
        'name' => $this->trainingProgram->translated_name,
        'level' => $this->trainingProgram->train_level,
        'original_price' => $this->trainingProgram->price,
        'discount' => $this->trainingProgram->discounts . '%',
      ],
      'subscribed_at' => $this->created_at->format('Y-m-d H:i'),
    ];
  }
}
