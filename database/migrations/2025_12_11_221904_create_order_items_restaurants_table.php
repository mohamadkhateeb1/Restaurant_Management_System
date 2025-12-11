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
        Schema::create('order_items_restaurants', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('dine_in_order_id')->nullable()->constrained('dine_in_orders')
            ->onDelete('set null');//ربطه بين طلب تناول الطعام داخل المطعم والعناصر
            $table->foreignId('take_away_order_id')->nullable()->constrained('take_away_orders')
            ->onDelete('set null');//ربطه بين الطلبات الخارجية والعناصر ال 
            //ondelete :(null)يعني اذا تم حذف الطلب يتم تعيين القيمة الى 
            $table->foreignId('item_id')->constrained('items_restaurants')->cascadeOnDelete();//ربطه بين الصنف والطلب
            $table->integer('quantity');//كمية الصنف في الطلب
            $table->decimal('price', 8, 2);//سعر الصنف في الطلب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items_restaurants');
    }
};
