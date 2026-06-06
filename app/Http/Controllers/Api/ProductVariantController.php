<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariant\CreateProductVariantRequest;
use App\Http\Requests\ProductVariant\UpdateProductVariantRequest;
use App\Http\Resources\ProductVariantResource;
use App\Models\ProductVariant;
use App\Services\ProductVariantService;

class ProductVariantController extends Controller
{
  public function __construct
  (
    private ProductVariantService $productVariantService
  ) {
  }

  public function index()
  {
    $variants = $this->productVariantService->findAll();
    return ProductVariantResource::collection($variants);
  }


  public function store(CreateProductVariantRequest $request)
  {
    $variant = $this->productVariantService->createProductVariant(
      $request->validated(),
    );
    return new ProductVariantResource($variant);
  }

  public function update(UpdateProductVariantRequest $request, ProductVariant $product_variant)
  {
    $variant = $this->productVariantService->updateProductVariant(
      $request->validated(),
      $product_variant,
    );
    return new ProductVariantResource($variant);
  }

  public function show(ProductVariant $product_variant)
  {
    $variant = $this->productVariantService->findOne($product_variant);
    return new ProductVariantResource($variant);
  }

  public function destroy(ProductVariant $product_variant)
  {
    $this->productVariantService->deleteProductVariant($product_variant);
    return response()->noContent();
  }

}