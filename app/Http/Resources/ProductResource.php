<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  // public function toArray(Request $request): array
  // {
  //   return [
  //     'id' => $this->id,
  //     'name' => $this->translated_name,
  //     'body' => $this->translated_body,
  //     'is_featured' => $this->is_featured,
  //     // category
  //     'category' => new CategoryResource($this->whenLoaded('category')),

  //   ];
  // }

  public function toArray(Request $request): array
  {
    $availableOptions = $this->variants->groupBy('color_id')->map(function ($colorGroup) {
      $color = $colorGroup->first()->color;
      if (!$color) return null;

      return [
        'id' => $color->id,
        'name' => $color->color,
        'hex' => $color->hex_code,
        'available_sizes' => $colorGroup->map(function ($variant) {
          $size = $variant->size;
          return [
            'id' => $size?->id,
            'name' => $size?->size,
            'variant_id' => $variant->id,
            'stock' => $variant->stock_quantity,
            'price' => $variant->price,
            'discount' => $variant->discount,
            'final_price' => $variant->final_price,
            'sku' => $variant->sku,
            'images' => $variant->images->map(function ($img) use ($variant) {
              return asset('storage/product_variants/' . $variant->id . '/' . $img->image);
            })->values(),
          ];
        })->values(),
      ];
    })->filter()->values();

    $defaultVariant = $this->variants->first();

    return [
      'id' => $this->id,
      'name' => $this->translated_name,
      'body' => $this->translated_body,
      'image' => $defaultVariant && $defaultVariant->images->first()
        ? asset('storage/product_variants/' . $defaultVariant->id . '/' . $defaultVariant->images->first()->image)
        : null,
      'all_images' => $this->variants->flatMap(function ($v) {
        return $v->images->map(fn($img) => asset('storage/product_variants/' . $v->id . '/' . $img->image));
      })->unique()->values(),

      'category' => $this->category ? [
        'id' => $this->category->id,
        'name' => $this->category->translated_name,
        'description' => $this->category->translated_description,
      ] : null,

      'available_options' => $availableOptions,
      'default_price' => $defaultVariant?->price,
      'default_discount' => $defaultVariant?->discount,
      'default_final_price' => $defaultVariant?->final_price,
      'default_stock' => $defaultVariant?->stock_quantity,
      'default_sku' => $defaultVariant?->sku,
    ];
  }
}
