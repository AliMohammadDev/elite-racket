<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController extends Controller
{
  public function __construct(private OrderService $orderService) {}

  public function index()
  {
    $orders = $this->orderService->getUserOrders();
    return OrderResource::collection($orders);
  }

  public function store()
  {
    $order = $this->orderService->createOrderFromCart();
    return
      new OrderResource($order);
  }

  public function destroy($id)
  {
    $this->orderService->cancelOrder($id);
    return true;
  }
}
