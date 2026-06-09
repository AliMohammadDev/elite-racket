<?php



namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderService
{

  public function getUserOrders()
  {
    return Order::where('user_id', Auth::id())
      ->with([
        'items.productVariant.product',
        'items.productVariant.color',
        'items.productVariant.size',
        'items.productVariant.images'
      ])
      ->latest()
      ->get();
  }


  public function createOrderFromCart()
  {
    return DB::transaction(function () {
      $cart = Cart::where('user_id', Auth::id())->with('items.productVariant')->first();

      if (!$cart || $cart->items->isEmpty()) {
        throw ValidationException::withMessages(['cart' => ['السلة فارغة.']]);
      }

      $total = 0;
      foreach ($cart->items as $item) {
        $variant = $item->productVariant;

        if ($variant->stock_quantity < $item->quantity) {
          throw ValidationException::withMessages(['stock' => ["المنتج {$variant->product->name} غير متوفر بالكمية المطلوبة."]]);
        }

        $total += ($variant->final_price * $item->quantity);
      }

      $order = Order::create([
        'user_id' => Auth::id(),
        'total_price' => $total,
        'status' => 'pending'
      ]);

      foreach ($cart->items as $item) {
        $order->items()->create([
          'product_variant_id' => $item->product_variant_id,
          'quantity' => $item->quantity,
          'price' => $item->productVariant->final_price,
        ]);

        $item->productVariant->decrement('stock_quantity', $item->quantity);
      }

      $cart->items()->delete();

      return $order->load('items');
    });
  }


  public function cancelOrder(int $id)
  {
    return DB::transaction(function () use ($id) {
      $order = Order::where('user_id', Auth::id())
        ->where('id', $id)
        ->with('items.productVariant')
        ->firstOrFail();

      if ($order->status !== 'pending') {
        throw ValidationException::withMessages(['status' => ['لا يمكن إلغاء الطلب بعد بدء المعالجة.']]);
      }

      foreach ($order->items as $item) {
        $item->productVariant->increment('stock_quantity', $item->quantity);
      }

      $order->update(['status' => 'cancelled']);
      return $order;
    });
  }
}