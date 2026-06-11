<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingCourtResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'           => $this->id,
      'court_name'   => $this->court->translated_name,
      'booking_date' => $this->booking_date->format('Y-m-d'),
      'total_price'  => (float) $this->total_price,
      'status'       => $this->status,
      'couch'        => $this->whenLoaded('couch', fn() => $this->couch->name),
      'times'        => $this->whenLoaded('times', function () {
        return $this->times->map(fn($t) => $t->from->format('H:i') . ' - ' . $t->to->format('H:i'));
      }),
    ];
  }
}
