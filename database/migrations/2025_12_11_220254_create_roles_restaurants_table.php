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
    {//إنشاء جدول الأدوار في المطعم
        Schema::create('roles_restaurants', function (Blueprint $table) {
                $table->id()->primary();
            $table->string('role_name')->unique();
            // $table->guard_name('role_guard')->default('web');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_restaurants');
    }
};
