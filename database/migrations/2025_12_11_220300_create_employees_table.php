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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
          
            $table->string('name'); // اسم الموظف
            $table->string('email')->unique(); // بريد الموظف الإلكتروني
            $table->string('phone')->unique(); // رقم هاتف الموظف يكون الرقم فريد لكل موظف رقم هاتف
            $table->string('position'); // وظيفة الموظف
            $table->decimal('salary', 10, 2); // راتب الموظف
            $table->string('password'); // كلمة مرور الموظف
            $table->date('hire_date'); // تاريخ التوظيف
            $table->text('notes')->nullable(); // ملاحظات إضافية عن الموظف
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة الموظف
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
