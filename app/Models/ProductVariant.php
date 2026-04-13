<?php

namespace App\Models;

use App\MediaLibrary\ProductPathGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

class ProductVariant extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;
  protected $fillable = [
    'product_id',
    'color_id',
    'size_id',
    'price',
    'discount',
    'stock_quantity',
    'sku',
    'barcode'
  ];

  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      ProductPathGenerator::class
    );
  }

  public function registerMediaConversions(?Media $media = null): void
  {
    $this->addMediaConversion('default')
      ->fit(Fit::Max, 1000, 1000)
      ->quality(70)
      ->format('webp')
      ->nonQueued();
  }


  protected static function boot()
  {
    parent::boot();

    static::creating(function ($variant) {
      if (empty($variant->sku)) {
        $variant->sku = self::generateUniqueSku();
      }
      if (empty($variant->barcode)) {
        $variant->barcode = self::generateUniqueBarcode();
      }
    });
  }

  public static function generateUniqueBarcode()
  {
    do {
      $barcode = mt_rand(100000000000, 999999999999);
    } while (self::where('barcode', $barcode)->exists());

    return $barcode;
  }

  public static function generateUniqueSku()
  {
    do {
      $sku = 'PROD-' . strtoupper(Str::random(8));
    } while (self::where('sku', $sku)->exists());

    return $sku;
  }

  public function getFinalPriceAttribute()
  {
    $discountedAmount = $this->price * ($this->discount / 100);
    return round($this->price - $discountedAmount, 2);
  }

  /*
  |--------------------------------------------------------------------------
  | Relationships
  |--------------------------------------------------------------------------
  */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function color()
  {
    return $this->belongsTo(Color::class);
  }

  public function size()
  {
    return $this->belongsTo(Size::class);
  }


}