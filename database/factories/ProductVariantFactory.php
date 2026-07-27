<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\WebpEncoder;



class ProductVariantFactory extends Factory
{
  protected $model = ProductVariant::class;

  private $imageUrls = [
    // Professional padel racket
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuYy_pDfY7LyHteEV2uI5YrKts2_dd5IQGvsMZtsk2bw&s',

    // Tennis racket and balls
    'https://as1.ftcdn.net/v2/jpg/00/91/43/24/1000_F_91432481_8f41LSneIZLb9L4JCrYURelRculHBSO9.jpg',

    // Tennis balls on court
    'https://inkarto.com/cdn/shop/products/parshwa-traders-tennis-ball-36960781140181.jpg?v=1760258584&width=360',

    // Tennis accessories and rackets
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3Km-GjTeSVVGo8B52B33khZmz8T2shQKypA4Un4hOgdaveXQ2sdAloePg&s=10',

    // Sports apparel clothing
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnLwMOUDU1FXOBrwDblONbv6GHIfl35tnC6KN0jMxLNuS6REkeTBZr0fF8&s=10',

    // Tennis player in white outfit
    'https://img.redbull.com/images/q_auto,f_auto/redbullcom/2026/6/23/d24rzaxyzrfkzsyo1eus/jakub-mesik-white-outfit-wimbledon',

    // Sports t-shirts
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4tVlBczF5F70Ia8528W7kAtfXNLk8QW_ihEjRLMYwhA&s',

    // Professional sports shoes
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjIh-mUXDAY2ULa5p5gFhAzmDT45b_2yVYydiAIGG_PcgWMozgNFtacqM&s=10',

    // Tennis racket bag
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4dubOOdI1tnqKo1MdVhnbt2Twjnzy-90_xxLaA2IL1nK5J7DIGI20g0k&s=10',

    // Padel training session
    'https://americano-padel.app/images/blog/padel-training-drills-two-players-court.webp',

    // Various sports equipment
    'https://t4.ftcdn.net/jpg/00/04/43/79/360_F_4437974_DbE4NRiaoRtUeivMyfPoXZFNdCnYmjPq.jpg',

    // Close-up padel racket
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR73veKqYG_cX9DR3BH3eHXa3EpXQM9Rrdb1HU84TXTrOF6tVjWEM6PrT3a&s=10',

    // Modern padel apparel
    'https://images.unsplash.com/photo-1560012057-4372e1e1c3e6?q=80&w=1000&auto=format&fit=crop',

    // Sun protection caps and accessories
    'https://sunprotectionclothing.co.uk/cdn/shop/files/pocket-wide-brim-sun-baseball-cap-7452306.png?v=1752255059&width=1200',

    // Padel and tennis fashion
    'https://images.ft.com/v3/image/raw/https%3A%2F%2Fd1e00ek4ebabms.cloudfront.net%2Fproduction%2Ff3b91437-d333-47a0-acfd-44289d418af8.jpg?source=next-article&fit=scale-down&quality=highest&width=700&dpr=1',

    // Additional tennis gear
    'https://greatcallathletics.com/cdn/shop/collections/a8e5a47e-801d-401a-bc70-667b2eb13936.png?v=1773782346&width=1024',
  ];
  public function definition(): array
  {
    return [
      'product_id' => null,
      'color_id' => Color::factory(),
      'size_id' => Size::factory(),
      'price' => $this->faker->randomFloat(2, 50, 500),
      'discount' => $this->faker->numberBetween(0, 30),
      'stock_quantity' => $this->faker->numberBetween(10, 100),
      'sku' => Str::upper(Str::random(10)),
      'barcode' => $this->faker->ean13(),
    ];
  }

  public function configure()
  {
    return $this->afterCreating(function (ProductVariant $variant) {
      $disk = Storage::disk('public');
      $variantDirectory = "product_variants/{$variant->id}";
      $disk->makeDirectory($variantDirectory);

      for ($i = 0; $i < 3; $i++) {
        try {
          $remoteUrl = $this->faker->randomElement($this->imageUrls);

          $response = Http::get($remoteUrl);

          if ($response->successful()) {
            $filename = Str::uuid() . '.webp';
            $finalPath = "{$variantDirectory}/{$filename}";

            $img = Image::decode($response->body())
              ->scaleDown(1000, 1000)
              ->encode(new WebpEncoder(quality: 70));

            $disk->put($finalPath, (string) $img);

            ProductVariantImage::create([
              'product_variant_id' => $variant->id,
              'image' => $filename,
            ]);

            if ($i === 0) {
              $variant->update(['image' => $filename]);
            }
          }
        } catch (\Exception $e) {
          logger()->error("Seeding Error: Variant Image failed - " . $e->getMessage());
        }
      }
    });
  }
}
