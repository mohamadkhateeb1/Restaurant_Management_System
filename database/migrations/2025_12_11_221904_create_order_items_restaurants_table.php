<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items_restaurants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dine_in_order_id')->nullable()->constrained('dine_in_order_restaurants')->onDelete('set null');
        $table->foreignId('take_away_order_id')->nullable()->constrained('take_aways_restaurants')->onDelete('set null');
        $table->foreignId('item_id')->constrained('items_restaurants')->cascadeOnDelete(); 
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items_restaurants');
    }
};