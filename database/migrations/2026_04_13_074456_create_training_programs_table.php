<?php

use App\Models\Couch;
use App\Models\SportType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('training_programs', function (Blueprint $table) {
      $table->id();
      $table->json('name');
      $table->foreignIdFor(SportType::class)->constrained();
      $table->decimal('price', 10, 2);
      $table->double('discounts')->default(0);
      $table->foreignIdFor(Couch::class)->constrained();
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->integer('users_count')->default(0);
      $table->enum('train_level', ['beginner', 'intermediate', 'advanced']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('training_programs');
  }
};
