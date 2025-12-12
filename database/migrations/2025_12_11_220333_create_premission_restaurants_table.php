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
    {//إنشاء جدول الأذونات في المطعم
        Schema::create('premission_restaurants', function (Blueprint $table) {
                $table->id();
            $table->string('permission_name')->unique();
            // $table->guard_name('permission_guard')->default('web');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premission_restaurants');
    }
};
