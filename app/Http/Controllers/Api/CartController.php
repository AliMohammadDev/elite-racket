<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Services\CartItemService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{

  public function __construct(private CartItemService $cartService) {}


  public function index(): JsonResponse
  {
    $cartItems = $this->cartService->getCartItems();

    return response()->json([
      'success' => true,
      'data' => CartItemResource::collection($cartItems)
    ]);
  }


  public function store(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'product_variant_id' => 'required|exists:product_variants,id',
      'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = $this->cartService->addToCart($validated);

    return response()->json([
      'success' => true,
      'message' => 'تم إضافة المنتج إلى السلة بنجاح.',
      'data' => new CartItemResource($cartItem)
    ]);
  }

  public function update(Request $request, $id): JsonResponse
  {
    $request->validate([
      'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = $this->cartService->updateQuantity($id, $request->quantity);

    return response()->json([
      'success' => true,
      'message' => 'تم تحديث الكمية بنجاح.',
      'data' => new CartItemResource($cartItem)
    ]);
  }


  public function destroy($id): JsonResponse
  {
    $this->cartService->removeItem($id);

    return response()->json([
      'success' => true,
      'message' => 'تم إزالة المنتج من السلة.'
    ]);
  }


  public function clear(): JsonResponse
  {
    $this->cartService->clearCart();

    return response()->json([
      'success' => true,
      'message' => 'تم تفريغ السلة بنجاح.'
    ]);
  }
}
