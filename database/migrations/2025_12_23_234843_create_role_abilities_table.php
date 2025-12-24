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
        Schema::create('role_abilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();// هذا يربط الجداول
            $table->string('ability');// هنا نحدد القدرة
            $table->enum('type', ['allow', 'deny' , 'inherit']);
            // كل دور بياخد الصلاحية لمر واحدة فقط
            $table->unique(['role_id', 'ability']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_abilities');
    }
};
