<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('items_restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->unique()->constrained('inventories')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories_restaurants')->cascadeOnDelete();
            $table->string('item_name');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('unit', 50);
            $table->decimal('min_quantity', 10, 2);
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->integer('prepare_time')->nullable();

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('items_restaurants');
    }
};
