<?php
namespace App\Services;

use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\WebpEncoder;

class ProductVariantService
{

  public function findAll()
  {
    return ProductVariant::with(['product', 'color', 'size', 'images'])->get();
  }
  public function findOne(ProductVariant $productVariant)
  {
    return $productVariant->load(['product', 'color', 'size', 'images']);
  }

  // ProductVariantService.php

  public function createProductVariant(array $data)
  {
    return DB::transaction(function () use ($data) {

      $variant = ProductVariant::create([
        'product_id' => $data['product_id'],
        'color_id' => $data['color_id'],
        'size_id' => $data['size_id'],
        'material_id' => $data['material_id'] ?? null,
        'price' => $data['price'],
        'discount' => $data['discount'] ?? 0,
        'stock_quantity' => $data['stock_quantity'],
        'image' => '',
      ]);

      $disk = Storage::disk('public');

      if (!empty($data['images']) && is_array($data['images'])) {

        $variantDirectory = "product_variants/{$variant->id}";
        $disk->makeDirectory($variantDirectory);

        foreach ($data['images'] as $index => $imageFile) {

          $filename = Str::uuid() . '.webp';
          $finalPath = "{$variantDirectory}/{$filename}";

          $img = Image::decode($imageFile)
            ->scaleDown(1000, 1000)
            ->encode(new WebpEncoder(quality: 70));

          $disk->put($finalPath, (string) $img);

          ProductVariantImage::create([
            'product_variant_id' => $variant->id,
            'image' => $filename,
          ]);

          if ($index === 0) {
            $variant->update(['image' => $filename]);
          }
        }
      }

      return $variant->load('images');
    });
  }

  public function updateProductVariant(array $data, ProductVariant $product_variant)
  {
    return DB::transaction(function () use ($data, $product_variant) {

      $product_variant->update($data);

      $disk = Storage::disk('public');
      $variantDirectory = "product_variants/{$product_variant->id}";

      if (!empty($data['images']) && is_array($data['images'])) {

        $disk->makeDirectory($variantDirectory);

        foreach ($data['images'] as $index => $imageFile) {

          $filename = Str::uuid() . '.webp';
          $finalPath = "{$variantDirectory}/{$filename}";

          $img = Image::decode($imageFile)
            ->scaleDown(1000, 1000)
            ->encode(new WebpEncoder(quality: 70));

          $disk->put($finalPath, (string) $img);

          ProductVariantImage::create([
            'product_variant_id' => $product_variant->id,
            'image' => $filename,
          ]);

          if ($index === 0 && empty($product_variant->image)) {
            $product_variant->update(['image' => $filename]);
          }
        }
      }

      return $product_variant->fresh(['images']);
    });
  }

  public function deleteProductVariant(ProductVariant $productVariant)
  {
    return $productVariant->delete();
  }

}
