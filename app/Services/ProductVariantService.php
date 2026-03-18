<?php
namespace App\Services;

use App\Models\ProductVariant;

class ProductVariantService
{

  public function findAll()
  {
    return ProductVariant::with(['product', 'color', 'size', 'media'])->get();
  }
  public function findOne(ProductVariant $productVariant)
  {
    return $productVariant->load(['product', 'color', 'size', 'media']);
  }

  // ProductVariantService.php

  public function createProductVariant(array $data, $image = null)
  {
    $variant = ProductVariant::create($data);

    if ($image) {
      if (is_array($image)) {
        foreach ($image as $img) {
          $variant->addMedia($img)->toMediaCollection('variants');
        }
      } else {
        $variant->addMedia($image)->toMediaCollection('variants');
      }
    }

    return $variant;
  }

  public function updateProductVariant(ProductVariant $productVariant, array $data, $image = null)
  {
    $productVariant->update($data);

    if ($image) {
      $productVariant->clearMediaCollection('variants');

      if (is_array($image)) {
        foreach ($image as $img) {
          $productVariant->addMedia($img)->toMediaCollection('variants');
        }
      } else {
        $productVariant->addMedia($image)->toMediaCollection('variants');
      }
    }

    return $productVariant;
  }
  public function deleteProductVariant(ProductVariant $productVariant)
  {
    return $productVariant->delete();
  }

}
