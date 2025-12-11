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
        Schema::create('dine_in_orders', function (Blueprint $table) {
            $table->id()->primary();
            $table->integer('table_id');
            $table->foreignId('user_id')->constrained('user_restaurants')->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'preparing', 'ready', 'paid'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dine_in_orders');
    }
};
