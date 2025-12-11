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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('dine_in_order_id')->nullable()->constrained('dine_in_orders')->onDelete('set null');
            $table->foreignId('takeaway_order_id')->nullable()->constrained('takeaway_orders')->onDelete('set null');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
