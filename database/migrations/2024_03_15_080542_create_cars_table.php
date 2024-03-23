<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('cars', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('color');
      $table->tinyText('description');
      $table->bigInteger('price')->unsigned();
      $table->string('transmission');
      $table->string('location');
      $table->string('condition');
      $table->integer('year');
      $table->integer('km');
      $table->integer('stock');
      $table->string('image');
      $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
      $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cars');
  }
};
