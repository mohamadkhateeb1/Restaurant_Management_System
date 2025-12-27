<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الميغريشن لإنشاء جدول الأصناف (المنيو المربوط بالمخزن).
     */
    public function up(): void
    {
        Schema::create('items_restaurants', function (Blueprint $table) {
            $table->id();

            // 1. الربط الجوهري مع سجل المخزن (المايسترو)
            // نستخدم unique لضمان أن كل مادة مخزنية لها سجل عرض واحد فقط في المنيو
            $table->foreignId('inventory_id')->unique()->constrained('inventories')->cascadeOnDelete();

            // 2. الربط مع القسم (يجب أن يكون القسم is_menu_category = true برمجياً)
            $table->foreignId('category_id')->constrained('categories_restaurants')->cascadeOnDelete();

            // 3. بيانات العرض (يتم مزامنتها آلياً من المخزن عند الإنشاء)
            $table->string('item_name'); // اسم الطبق المعروض للزبائن
            $table->decimal('quantity', 10, 2)->default(0); // للوصول السريع للكمية
            $table->string('unit', 50); // قطعة، وجبة، لتر.. إلخ
            $table->decimal('min_quantity', 10, 2); // حد التنبيه

            // 4. بيانات تسويقية وبيعية (خاصة بالمنيو فقط)
            $table->decimal('price', 10, 2); // سعر البيع للزبون
            $table->text('description')->nullable(); // وصف المكونات
            $table->string('image')->nullable(); // صورة الطبق
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->integer('prepare_time')->nullable(); // وقت التحضير بالدقائق
            
            $table->timestamps();
        });
    }

    /**
     * التراجع عن الميغريشن.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_restaurants');
    }
};