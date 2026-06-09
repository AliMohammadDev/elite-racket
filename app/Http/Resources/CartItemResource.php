<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $variant = $this->productVariant;
    $product = $variant ? $variant->product : null;

    return [
      'id' => $this->id,
      'quantity' => $this->quantity,
      'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

      'product' => $product ? [
        'id' => $product->id,
        'name' => $product->translated_name,
      ] : null,

      'variant' => $variant ? [
        'id' => $variant->id,
        'price' => (float)$variant->price,
        'discount' => (float)$variant->discount,
        'final_price' => (float)$variant->final_price,
        'stock_quantity' => (int)$variant->stock_quantity,
        'sku' => $variant->sku,

        'color' => $variant->color ? [
          'id' => $variant->color->id,
          'color' => $variant->color->color,
          'hex_code' => $variant->color->hex_code,
        ] : null,

        'size' => $variant->size ? [
          'id' => $variant->size->id,
          'size' => $variant->size->size,
        ] : null,

        'image' => $variant->images->isNotEmpty()
          ? asset('storage/product_variants/' . $variant->id . '/' . $variant->images->first()->image)
          : null,

        'images' => $variant->images->map(function ($img) use ($variant) {
          return asset('storage/product_variants/' . $variant->id . '/' . $img->image);
        }),
      ] : null,
    ];
  }
}
