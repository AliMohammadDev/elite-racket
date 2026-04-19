<?php

use App\Models\CourtBooking;
use App\Models\Time;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('booking_times', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Time::class)->constrained();
      $table->foreignIdFor(CourtBooking::class)->constrained()->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('booking_times');
  }
};