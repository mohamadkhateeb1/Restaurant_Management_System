<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemsRestaurant extends Model
{
    protected $table = 'items_restaurants';

    protected $fillable = [
        'category_id',
        'inventory_id', // الحقل الأساسي للربط مع المخزن
        'item_name',    
        'description',
        'image',
        'price',        
        'status',
        'prepare_time',
        'quantity',     
        'unit',         
        'min_quantity'  
    ];

    /**
     * العلاقة مع القسم التنظيمي
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoriesRestaurant::class, 'category_id');
    }

    /**
     * العلاقة مع المخزن (المصدر الأساسي للحقيقة)
     * من خلال هذه العلاقة، يستطيع الكاشير الوصول للكمية الحقيقية وخصمها
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    /**
     * العلاقة مع تفاصيل الطلبات (Order Items)
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItemsRestaurant::class, 'item_id');
    }

    // --- وظائف مساعدة (Helpers) لضمان دقة النظام ---

    /**
     * التحقق من توفر الصنف للطلب
     * يضمن أن الصنف متاح، والكمية في المخزن أكبر من صفر، والقسم نشط
     */
    public function isAvailableToOrder(): bool
    {
        // استخدام optional لتجنب الخطأ في حال لم يتم العثور على سجل في المخزن أو القسم
        return $this->status === 'available' &&
               optional($this->inventory)->quantity > 0 &&
               optional($this->category)->status === 'active';
    }


   // "Attribute" تجلب لك الكمية الحالية من المخزن مباشرة في أي وقت
public function getCurrentQuantityAttribute()
{
    return $this->inventory ? $this->inventory->quantity : 0;
}
}