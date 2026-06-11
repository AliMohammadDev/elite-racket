<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingProgramResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $user = $request->user();

    $isSubscribed = false;
    if ($user) {
      $isSubscribed = $this->subscriptions()
        ->where('user_id', $user->id)
        ->whereHas('trainingProgram', function ($query) {
          $query->where('end_date', '>=', now());
        })
        ->exists();
    }

    return [
      'id' => $this->id,
      'name' => $this->translated_name,
      'price' => $this->price,
      'discount' => $this->discounts,
      'final_price' => $this->final_price,
      'level' => $this->train_level,
      'is_subscribed' => $isSubscribed,
      'couch' => new CouchResource($this->whenLoaded('couch')),
      'users_count' => $this->subscriptions()->count(),
      'sport_type' => new SportTypeResource($this->whenLoaded('sportType')),
      'created_at' => $this->created_at->format('Y-m-d'),
      'image' => $this->getFirstMediaUrl('training_programs', 'default'),
      'all_images' => $this->getMedia('training_programs')->map(fn($media) => $media->getUrl('default')),
    ];
  }
}
