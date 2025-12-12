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
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('user_restaurants')->onDelete('cascade');//هذا يربط جدول المستخدمين
            $table->foreignId('role_id')->constrained('roles_restaurants')->onDelete('cascade');//هذا يربط جدول الأدوار
            $table->primary(['user_id','role_id']);//مفتاح أساسي مركب لضمان عدم تكرار الأدوار لنفس المستخدم
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');//حذف الجدول عند التراجع عن الترحيل
    }
};
