<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
  public function __invoke(Request $request)
  {
    $message = $request->input('message');

    $response = AiService::chat($message);

    return response()->json([
      'reply' => $response
    ]);
  }
}
