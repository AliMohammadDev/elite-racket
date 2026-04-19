<?php

use App\Models\Couch;
use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('court_bookings', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Court::class)->constrained();
      $table->foreignIdFor(Couch::class)
        ->nullable()
        ->constrained();
      $table->foreignIdFor(User::class)->constrained();
      $table->decimal('total_price', 10, 2)
        ->default(0);
      $table->enum('status', ['pending', 'approved', 'rejected','completed'])
        ->default('pending');
      $table->dateTime('booking_date');
      $table->timestamps();

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('court_bookings');
  }
};
