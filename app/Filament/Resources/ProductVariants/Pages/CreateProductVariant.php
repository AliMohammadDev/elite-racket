<?php

namespace App\Filament\Resources\ProductVariants\Pages;

use App\Filament\Resources\ProductVariants\ProductVariantResource;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\WebpEncoder;
use Filament\Actions;


class CreateProductVariant extends CreateRecord
{
  protected static string $resource = ProductVariantResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }

  protected function handleRecordCreation(array $data): Model
  {
    $productId = $data['product_id'];
    $lastRecord = null;

    foreach ($data['variants'] as $variantData) {

      $variant = ProductVariant::create([
        'product_id' => $productId,
        'color_id' => $variantData['color_id'],
        'size_id' => $variantData['size_id'],
        'price' => $variantData['price'],
        'discount' => $variantData['discount'] ?? 0,
        'stock_quantity' => $variantData['stock_quantity'],
        'sku' => $variantData['sku'],
        'barcode' => $variantData['barcode'] ?? null,
        'image' => '',
      ]);
      $disk = Storage::disk('public');
      $images = collect($variantData['images'] ?? [])
        ->filter()
        ->values();

      if ($images->isEmpty()) {
        $lastRecord = $variant;
        continue;
      }

      $variantDirectory = "product_variants/{$variant->id}";
      $disk->makeDirectory($variantDirectory);

      foreach ($images as $index => $tempPath) {
        if (!$disk->exists($tempPath)) {
          continue;
        }
        $file = $disk->get($tempPath);
        if (!$file) {
          continue;
        }
        $filename = Str::uuid() . '.webp';
        $finalPath = "{$variantDirectory}/{$filename}";
        $img = Image::decode($file)
          ->scaleDown(1000, 1000)
          ->encode(new WebpEncoder(quality: 70));
        $disk->put($finalPath, $img);
        ProductVariantImage::create([
          'product_variant_id' => $variant->id,
          'image' => $filename,
        ]);
        if ($index === 0) {
          $variant->update(['image' => $filename]);
        }
        $disk->delete($tempPath);
      }

      $lastRecord = $variant;
    }

    return $lastRecord;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
