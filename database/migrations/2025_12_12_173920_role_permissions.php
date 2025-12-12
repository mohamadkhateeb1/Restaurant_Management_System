<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // جدول لربط الأدوار بالمستخدمين
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // جدول وسيط لنربط ال دور بالصلاحيات
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles_restaurants')->onDelete('cascade');//هذا يربط جدول الأدوار
            $table->foreignId('permission_id')->constrained('premission_restaurants')->onDelete('cascade');//هذا يربط جدول الأذونات
            $table->primary(['role_id','permission_id']);//مفتاح أساسي مركب لضمان عدم تكرار الأذونات لنفس الدور
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');//حذف الجدول عند التراجع عن الترحيل
    }
};
