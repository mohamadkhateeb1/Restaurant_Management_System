<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique(); 
    $table->foreignId('dine_in_order_id')->nullable()->constrained('dine_in_order_restaurants')->onDelete('set null');
    $table->foreignId('takeaway_order_id')->nullable()->constrained('take_aways_restaurants')->onDelete('set null');
    $table->foreignId('employee_id')->constrained('employees');
    $table->decimal('amount_paid', 12, 2); 
    $table->enum('payment_status', ['paid', 'pending', 'refunded'])->default('paid');
    $table->timestamps(); 
});
    }

 
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
