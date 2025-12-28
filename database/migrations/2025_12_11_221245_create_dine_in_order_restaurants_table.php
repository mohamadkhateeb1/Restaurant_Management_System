<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('dine_in_order_restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('tables_restaurants')->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'preparing', 'ready', 'paid'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dine_in_order_restaurants');
    }
};
