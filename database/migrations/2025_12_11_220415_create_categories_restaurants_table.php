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
    {//إنشاء جدول فئات الأصناف في المطعم
        Schema::create('categories_restaurants', function (Blueprint $table) {
           $table->id()->primary();
            $table->string('category_name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_restaurants');
    }
};
