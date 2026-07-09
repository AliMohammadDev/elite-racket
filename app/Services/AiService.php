<?php

namespace App\Services;

use App\Models\Product;
use Prism\Prism\Facades\Prism;

class AiService
{
  public static function generateCategoryDescription(
    string $categoryName
  ): array {

    $response = Prism::text()
      ->using('gemini', 'gemini-3.1-flash-lite')
      ->withPrompt("
  Category Name: {$categoryName}

  Generate a short ecommerce category description.

  Do not use:
  - **
  - #
  - ---
  - bullet points
  - titles

  Return only:

  AR:
  ...

  EN:
  ...

  Return exactly:

  AR:
  description

  EN:
  description
  ")
      ->generate();

    $text = $response->text;

    preg_match(
      '/AR:(.*?)EN:(.*)/s',
      $text,
      $matches
    );

    return [
      'ar' => trim($matches[1] ?? ''),
      'en' => trim($matches[2] ?? ''),
    ];
  }




  public static function generateProductDescription(
    string $nameAr,
    string $nameEn
  ): array {

    $response = Prism::text()
      ->using('gemini', 'gemini-3.1-flash-lite')
      ->withPrompt("
Product Name Arabic: {$nameAr}
Product Name English: {$nameEn}

Generate a short ecommerce product description.

Rules:
- Maximum 3 sentences.
- No headings.
- No titles.
- No markdown.
- No bullet points.
- No promotional phrases.
- Return plain text only.

Return exactly:

AR:
description

EN:
description
")
      ->generate();

    $text = $response->text;

    preg_match(
      '/AR:(.*?)EN:(.*)/s',
      $text,
      $matches
    );

    return [
      'ar' => trim($matches[1] ?? ''),
      'en' => trim($matches[2] ?? ''),
    ];
  }



  public static function chat(string $message)
  {
    $products = Product::with([
      'category',
      'variants.color',
      'variants.size',
      'variants.images'
    ])
      ->limit(50)
      ->get()
      ->map(function ($product) {
        $availableOptions = $product->variants->groupBy('color_id')->map(function ($colorGroup) {
          $color = $colorGroup->first()->color;
          if (!$color) return null;

          return [
            'color_name' => $color->color,
            'sizes' => $colorGroup->map(function ($variant) {
              $size = $variant->size;
              return [
                'size_name' => $size?->size,
                'price' => $variant->price,
                'discount' => $variant->discount,
                'final_price' => $variant->final_price,
                'stock' => $variant->stock_quantity,
              ];
            })->values(),
          ];
        })->filter()->values();

        $defaultVariant = $product->variants->first();

        return [
          'id' => $product->id,
          'name' => $product->translated_name, // استخدام حقل الترجمة التلقائي بناءً على لغة الهيدر
          'category' => $product->category ? $product->category->translated_name : null, // ترجمة القسم أيضاً
          'available_options' => $availableOptions,
          'default_price' => $defaultVariant?->price,
          'default_final_price' => $defaultVariant?->final_price,
          'default_stock' => $defaultVariant?->stock_quantity,
        ];
      });

    $context = json_encode($products);

    return Prism::text()
      ->using('gemini', 'gemini-3.1-flash-lite')
      ->withPrompt("
You are an ecommerce chatbot.

User message:
{$message}

Available products:
{$context}

Rules:
- Use ONLY the products provided.
- Reply in the same language as the user.
- Return plain text only.
- Do NOT use markdown, bullet points, numbering, bold text, or headings.
- Do NOT ask follow-up questions or suggest adding to cart.
- Maximum 2 short sentences.
- Mention product names naturally inside the sentence exactly as provided in the 'name' field.
- Check the 'available_options' array for specific colors, sizes, prices, and stock when asked.
- If a product has a discount, mention the 'final_price'.
- If multiple products match, recommend up to 3 products only.
- If no product matches, say so politely.

Now answer:
{$message}
")
      ->generate()
      ->text;
  }
}
