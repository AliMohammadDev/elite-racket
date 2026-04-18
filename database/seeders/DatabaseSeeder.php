<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      AdminSeeder::class,
      UserSeeder::class,
      CategorySeeder::class,
      ProductSeeder::class,
      CourtSeeder::class,
      CouchSeeder::class,
      TrainingProgramSeeder::class,
      TrainingSubscriptionSeeder::class
    ]);



    $colors = Color::factory(10)->create();
    $sizes = Size::factory(10)->create();
    $products = Product::all();

    foreach ($products as $product) {
      $combinations = [];

      for ($i = 0; $i < 2; $i++) {
        $c_id = $colors->random()->id;
        $s_id = $sizes->random()->id;

        $key = "{$c_id}-{$s_id}";
        if (in_array($key, $combinations)) {
          continue;
        }
        $combinations[] = $key;
        $randomQuantity = rand(50, 200);
        ProductVariant::factory()->create([
          'product_id' => $product->id,
          'color_id' => $c_id,
          'size_id' => $s_id,
          'stock_quantity' => $randomQuantity,
        ]);
      }
    }


  }





}
