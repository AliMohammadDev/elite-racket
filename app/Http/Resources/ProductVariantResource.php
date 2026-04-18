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
      'image' => $this->image
        ? asset('storage/product_variants/' . $this->id . '/' . $this->image)
        : ($this->images->first()
          ? asset('storage/product_variants/' . $this->id . '/' . $this->images->first()->image)
          : null),

      'product_all_images' => $this->images->map(function ($img) {
        return asset('storage/product_variants/' . $this->id . '/' . $img->image);
      }),

      'product' => $this->whenLoaded('product', function () {
        return [
          'id' => $this->product->id,
          'name' => $this->product->translated_name,
          'body' => $this->product->translated_body,

          'category' => $this->product->category ? [
            'id' => $this->product->category->id,
            'name' => $this->product->category->translated_name,
            'description' => $this->product->category->translated_description,
            'image' => $this->product->category->getFirstMediaUrl('categories', 'default'),
            'all_images' => $this->product->category->getMedia('categories')->map(function ($media) {
              return $media->getUrl('default');
            }),
          ] : null,

          'available_options' => $this->product->variants->groupBy('color_id')->map(function ($colorGroup) {
            $color = $colorGroup->first()->color;
            return [
              'id' => $color->id,
              'name' => $color->color,
              'hex' => $color->hex_code,
              'available_sizes' => $colorGroup->map(function ($variant) {
                $size = $variant->size;
                return [
                  'id' => $size->id,
                  'name' => $size->size,
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
          })->values(),
        ];
      }),

      'price' => $this->price,
      'discount' => $this->discount,
      'final_price' => $this->final_price,
      'current_color' => $this->color ? $this->color->color : null,
      'current_size' => $this->size ? $this->size->size : null,
      'stock_quantity' => $this->stock_quantity,
      'sku' => $this->sku,
    ];
  }
}
