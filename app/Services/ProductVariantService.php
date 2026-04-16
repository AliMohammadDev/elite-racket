<?php
namespace App\Services;

use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
      $manager = new ImageManager(new Driver());

      $variant = ProductVariant::create([
        'product_id' => $data['product_id'],
        'color_id' => $data['color_id'],
        'size_id' => $data['size_id'],
        'material_id' => $data['material_id'],
        'price' => $data['price'],
        'discount' => $data['discount'] ?? 0,
        'stock_quantity' => $data['stock_quantity'],
        'image' => '',
      ]);

      if (isset($data['packages']) && is_array($data['packages'])) {
        foreach ($data['packages'] as $packageData) {
          $variant->packages()->create([
            'quantity' => $packageData['quantity'],
            'price' => $packageData['price'],
          ]);
        }
      }

      if (isset($data['images']) && is_array($data['images'])) {
        $variantDirectory = "product_variants/{$variant->id}";

        if (!Storage::disk('public')->exists($variantDirectory)) {
          Storage::disk('public')->makeDirectory($variantDirectory);
        }

        foreach ($data['images'] as $index => $imageFile) {
          $filename = Str::uuid() . '.webp';
          $finalPath = "{$variantDirectory}/{$filename}";

          $img = $manager->read($imageFile)
            ->scale(width: 1000, height: 1000)
            ->toWebp(70);

          Storage::disk('public')->put($finalPath, (string) $img);

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

      if (isset($data['images']) && is_array($data['images'])) {
        $manager = new ImageManager(new Driver());

        $variantDirectory = "product_variants/{$product_variant->id}";

        if (!Storage::disk('public')->exists($variantDirectory)) {
          Storage::disk('public')->makeDirectory($variantDirectory);
        }

        foreach ($data['images'] as $index => $imageFile) {
          $filename = (string) Str::uuid() . '.webp';
          $finalPath = "{$variantDirectory}/{$filename}";

          $img = $manager->read($imageFile)
            ->scale(width: 1000, height: 1000)
            ->toWebp(70);

          Storage::disk('public')->put($finalPath, (string) $img);

          ProductVariantImage::create([
            'product_variant_id' => $product_variant->id,
            'image' => $filename,
          ]);

          if (empty($product_variant->image)) {
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
