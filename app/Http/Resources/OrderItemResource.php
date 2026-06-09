<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
      'quantity' => $this->quantity,
      'price' => (float) $this->price,

      'product' => [
        'id' => $this->productVariant->product->id,
        'name' => $this->productVariant->product->translated_name,
      ],

      'variant' => [
        'id' => $this->productVariant->id,
        'color' => $this->productVariant->color->color ?? null,
        'size' => $this->productVariant->size->size ?? null,
      ],

      'image' => $this->productVariant->images->first()
        ? asset('storage/product_variants/' . $this->productVariant->id . '/' . $this->productVariant->images->first()->image)
        : null,
    ];
  }
}
