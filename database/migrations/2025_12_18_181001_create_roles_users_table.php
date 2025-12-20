<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            // authorizable_id & authorizable_type
            $table->morphs('authorizable');
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            
            // إضافة اسم فريد للـ Unique لضمان عدم تكرار الدور لنفس المستخدم
            $table->unique(['authorizable_id', 'role_id', 'authorizable_type'], 'role_user_morph_unique'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // تم تصحيح اسم الجدول هنا ليتطابق مع up
        Schema::dropIfExists('role_user');
    }
};