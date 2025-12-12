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
            $table->id()->primary();
            $table->foreignId('user_restaurant_id')->nullable()->constrained('user_restaurants')->cascadeOnDelete();// ربط الموظف بالمستخدم في المطعم ان وجد
            $table->string('name'); // اسم الموظف
            $table->string('email')->unique(); // بريد الموظف الإلكتروني
            $table->string('phone'); // رقم هاتف الموظف
            $table->string('position'); // وظيفة الموظف
            $table->decimal('salary', 10, 2); // راتب الموظف
            $table->date('hire_date'); // تاريخ التوظيف
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
