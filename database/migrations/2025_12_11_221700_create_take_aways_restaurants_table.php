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
    {//إنشاء جدول الطلبات الخارجية
        Schema::create('take_aways_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();//رقم الطلب
            $table->string('customer_name')->nullable();//اسم الزبون
            $table->foreignId('employee_id')->nullable()->constrained('employees')->cascadeOnDelete();//ربطه بين الطلب والموظف الذي قام بأخذ الطلب
            $table->string('customer_phone')->nullable();//رقم هاتف الزبون
            $table->enum('status', ['pending', 'preparing', 'ready', 'paid'])->default('pending');//حاله الطلب
            $table->decimal('total_amount', 10, 2);//المبلغ الكلي للطلب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_aways_restaurants');
    }
};
