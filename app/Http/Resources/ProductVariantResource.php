<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
      'sku' => $this->sku,
      'price' => (float) $this->price,
      'discount' => (float) $this->discount,
      'final_price' => $this->final_price,
      'stock_quantity' => $this->stock_quantity,
      'main_image' => $this->getFirstMediaUrl('variants', 'default'),
      'all_images' => $this->getMedia('variants')->map(function ($media) {
        return [
          'id' => $media->id,
          'url' => $media->getUrl('default'),
        ];
      }),

      'product' => $this->whenLoaded('product'),
      'color' => $this->whenLoaded('color'),
      'size' => $this->whenLoaded('size'),
    ];
  }
}