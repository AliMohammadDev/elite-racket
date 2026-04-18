<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
  use HasFactory;
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

  public function images()
  {
    return $this->hasMany(ProductVariantImage::class, 'product_variant_id');
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