<?php

namespace App\Filament\Resources\ProductVariants\Pages;

use App\Filament\Resources\ProductVariants\ProductVariantResource;
use App\Models\ProductVariant;
use Filament\Resources\Pages\CreateRecord;

class CreateProductVariant extends CreateRecord
{
  protected static string $resource = ProductVariantResource::class;


  protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
  {
    $productId = $data['product_id'];
    $lastRecord = null;

    if (!empty($data['variants'])) {
      foreach ($data['variants'] as $variantData) {
        $lastRecord = ProductVariant::create([
          'product_id' => $productId,
          'color_id' => $variantData['color_id'],
          'size_id' => $variantData['size_id'],
          'price' => $variantData['price'],
          'discount' => $variantData['discount'] ?? 0,
          'stock_quantity' => $variantData['stock_quantity'],
          'sku' => $variantData['sku'] ?? null,
        ]);
      }
    } else {
      $lastRecord = ProductVariant::create($data);
    }

    return $lastRecord;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

}