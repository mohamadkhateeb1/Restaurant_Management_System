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
  Schema::create('inventory_transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete();
    $table->foreignId('performed_by_user')->constrained('employees')->cascadeOnDelete(); // الربط المفقود
    $table->enum('transaction_type', ['in', 'out']);
    $table->decimal('quantity', 10, 2);
    $table->decimal('unit_price', 10, 2)->nullable();
    $table->text('notes')->nullable(); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invetory_transactions');
    }
};
