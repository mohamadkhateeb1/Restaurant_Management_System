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
    {//إنشاء جدول الطاولات في المطعم
        Schema::create('tables_restaurants', function (Blueprint $table) {
            $table->id();
            $table->integer('table_number')->unique();
            $table->integer('seating_capacity');
            $table->enum('status', ['available', 'occupied', 'reserved'])->default('available');
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables_restaurants');
    }
};
