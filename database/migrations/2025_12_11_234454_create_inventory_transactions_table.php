<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete(); 
            $table->enum('type', ['in', 'out', 'adjustment']); 
            $table->decimal('quantity', 10, 2); 
            $table->string('reference')->nullable(); 
            $table->text('notes')->nullable(); 
            $table->foreignId('employee_id')->constrained('employees'); 
            $table->timestamp('created_at'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
