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
        Schema::create('invetories', function (Blueprint $table) {
            $table->id();
            $table->string('item_name')->unique(); // اسم الصنف
            $table->decimal('quantity', 10, 2); // الكمية المتوفرة
            $table->decimal('min_quantity', 10, 2); // الحد الأدنى للكمية
            $table->string('unit'); // وحدة القياس (مثل: kg, liters, pieces)
            $table->decimal('cost_per_unit', 10, 2)->nullable(); // تكلفة لكل وحدة
            $table->string('supplier_name')->nullable(); // اسم المورد (اختياري)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invetories');
    }
};
