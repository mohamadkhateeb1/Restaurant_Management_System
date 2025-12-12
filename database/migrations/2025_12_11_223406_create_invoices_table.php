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
    $table->string('invoice_number')->unique(); // رقم الفاتورة الفريد
    // 1. المفتاح الخارجي للطلب الداخلي (Dine-In Order)
    // يجب أن يكون NULLABLE لأنه قد تكون الفاتورة لطلب سفري.
    $table->foreignId('dine_in_order_id')->nullable()
->constrained('dine_in_order_restaurants') // يربط بجدول الطلبات الداخلية
          ->onDelete('set null'); // يحافظ على سجل الفاتورة إذا حُذف الطلب
    $table->foreignId('takeaway_order_id')->nullable()
          ->constrained('take_aways_restaurants') // يربط بجدول الطلبات السفرية
          ->onDelete('set null'); // يحافظ على سجل الفاتورة إذا حُذف الطلب
    $table->decimal('amount_paid', 10, 2); // المبلغ المدفوع الفعلي
    $table->enum('payment_status', ['paid', 'unpaid']); // طريقة الدفع
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
