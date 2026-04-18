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
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494439/pexels-cottonbro-5739125_t12zud.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494438/pexels-cottonbro-5740525_e0wcj2.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494436/pexels-ellie-burgin-1661546-17429850_b8emoc.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494435/661ca846489ab67d8c5776bddd21c9b1_oivbtj.webp',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494435/paddle-tennis-ibiza-villa_pk4zbn.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494434/pexels-hson-27151849_bh2tok.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494433/pexels-ridwan-nugraha-692540814-35214630_up1hzz.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494433/pexels-ridwan-nugraha-692540814-35214649_qcgpem.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494431/pexels-tochtliyeung1996-34116479_rzwowb.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494430/pexels-thomas-plets-1139798-8894610_bm4n81.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494429/pexels-sonny-29248906_blviup.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494434/pexels-mutecevvil-22931869_yp16o1.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494434/pexels-franki-frank-27440719_foepct.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494433/pexels-ozanyavuzphoto-31054362_harnrk.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494431/pexels-tuan-vy-903011268-29696876_uhrioe.jpg',
    'https://res.cloudinary.com/dzvrf9xe3/image/upload/v1776494430/pexels-tochtliyeung1996-34116480_a145rq.jpg',
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
