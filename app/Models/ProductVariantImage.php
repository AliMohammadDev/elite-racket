<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantImage extends Model
{
  protected $fillable = ['product_variant_id', 'image'];

  public function variant()
  {
    return $this->belongsTo(ProductVariant::class, 'product_variant_id');
  }

  public function getImageUrlAttribute()
  {
    return $this->image
      ? "product_variants/{$this->product_variant_id}/{$this->image}"
      : null;
  }
}
