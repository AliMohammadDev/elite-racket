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
    return [
      'id' => $this->id,
      'name' => $this->translated_name,
      'price' => $this->price,
      'discount' => $this->discounts . '%',
      'final_price' => $this->final_price,
      'level' => $this->train_level,
      'couch' => new CouchResource($this->whenLoaded('couch')),
      'created_at' => $this->created_at->format('Y-m-d'),
    ];
  }
}
