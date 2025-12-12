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
    {//إنشاء جدول الأصناف في المطعم
        Schema::create('items_restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories_restaurants')->cascadeOnDelete();
            $table->string('item_name')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 8, 2);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->integer('prepare_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_restaurants');
    }
};
