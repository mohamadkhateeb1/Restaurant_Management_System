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
    { //إنشاء جدول الأصناف في المطعم
        Schema::create('items_restaurants', function (Blueprint $table) {
            $table->id(); //المعرف الأساسي للجدول
            $table->foreignId('category_id')->constrained('categories_restaurants')->cascadeOnDelete(); //معرف الفئة المرتبطة بالجدول الفئات
            $table->string('item_name'); //اسم الصنف
            $table->text('description')->nullable(); //وصف الصنف
            $table->string('image')->nullable(); //صورة الصنف
            $table->decimal('price', 8, 2); //سعر الصنف
            $table->enum('status', ['available', 'unavailable'])->default('available'); //حالة الصنف(متوفر أو غير متوفر)
            $table->integer('prepare_time')->nullable(); //وقت التحضير بالدقائق
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_restaurants');
    }
};
