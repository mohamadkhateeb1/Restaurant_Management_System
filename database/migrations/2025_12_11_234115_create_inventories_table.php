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
       Schema::create('inventories', function (Blueprint $table) {
    $table->id();
    $table->string('item_name')->unique();
    $table->decimal('quantity', 10, 2);
    $table->decimal('min_quantity', 10, 2);
    $table->string('unit');
    $table->decimal('cost_per_unit', 10, 2)->nullable();
    $table->string('supplier_name')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invetories');
    }
};
