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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            
            // نوع التقرير (sales, inventory, employees, kitchen, tables)
            $table->string('report_type'); 
            
            // مسمى التقرير (مثلاً: تقرير المبيعات الأسبوعي)
            $table->string('title'); 
            
            // الموظف الذي قام باستخراج التقرير
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            // تاريخ بداية ونهاية البيانات التي يغطيها التقرير
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            
            /**
             * تم استبدال الـ JSON بحقل نصي طويل (text) 
             * يمكن استخدامه لكتابة ملاحظات التقرير أو الوصف بدلاً من البيانات الهيكلية
             */
            $table->text('description')->nullable(); 
            
            // ملخص سريع (مثل إجمالي المبيعات أو عدد النواقص) ليظهر في جدول الأرشيف
            $table->decimal('total_summary', 15, 2)->default(0);
            
            // مسار ملف PDF إذا تم حفظه فعلياً على السيرفر
            $table->string('file_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};