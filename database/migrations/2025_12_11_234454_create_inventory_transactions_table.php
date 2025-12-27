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
            $table->id(); // المعرف
            $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete(); // معرف المادة
            $table->enum('type', ['in', 'out', 'adjustment']); // نوع الحركة
            $table->decimal('quantity', 10, 2); // الكمية
            $table->string('reference')->nullable(); // مرجع العملية
            $table->text('notes')->nullable(); // ملاحظات
            $table->foreignId('employee_id')->constrained('employees'); // الموظف الذي قام بالحركة
            $table->timestamp('created_at'); // تاريخ الحركة
            //useCurrent يضمن أن يتم تعيين الطابع الزمني الحالي عند إنشاء السجل
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
