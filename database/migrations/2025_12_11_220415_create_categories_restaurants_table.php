<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الميغريشن لإنشاء جدول الأقسام.
     */
    public function up(): void
    {
        Schema::create('categories_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // اسم القسم (مثل: وجبات سريعة، مواد أولية)
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            /**
             * التعديل الجذري: تحديد نطاق عمل القسم
             * true (1): قسم تجاري يظهر في (المنيو + المخزن) - للوجبات والمشروبات.
             * false (0): قسم إداري يظهر في (المخزن فقط) - للمواد الخام والمنظفات.
             */
            $table->boolean('is_menu_category')->default(true);

            $table->timestamps();
        });
    }

    /**
     * التراجع عن الميغريشن.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_restaurants');
    }
};