<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categories_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_menu_category')->default(true);
            $table->timestamps();
        });
    }

    /**
     * التراجع عن الميغريشن.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_restaurants');
    }
};