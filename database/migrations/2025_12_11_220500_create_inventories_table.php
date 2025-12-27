<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            
            // الربط مع الأقسام (التي ستحدد لاحقاً هل المادة للعرض أم لا)
            $table->foreignId('category_id')->constrained('categories_restaurants')->onDelete('cascade');
            
            // تحديد نوع المادة: مادة خام (Raw) أو صنف منيو (Menu Item)
            $table->enum('item_type', ['raw_material', 'menu_item'])->default('raw_material');
            
            $table->string('name');
            $table->string('sku', 100)->unique();
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('unit', 50);
            $table->decimal('min_quantity', 10, 2);
            $table->decimal('cost_per_unit', 10, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};