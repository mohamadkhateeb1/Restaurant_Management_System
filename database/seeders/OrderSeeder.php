<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRestaurant;
use App\Models\TablesRestaurant;
use App\Models\ItemsRestaurant;

class OrderSeeder extends Seeder
{
    // نفترض أن هذا المستخدم موجود من خلال UserSeeder
    public function run(): void
    {
        $waiter = UserRestaurant::where('email', 'ali@app.com')->first();
        $table1 = TablesRestaurant::first(); // نفترض وجود طاولة
        
        if ($waiter && $table1) {
            
            // 1. إنشاء طلب داخلي (Dine-In)
            $dineInOrder = $waiter->dineInOrders()->create([
                'order_number' => 'DIN001',
                'status' => 'paid',
                'total_amount' => 125.00, // ❌ تصحيح: استخدام الاسم الأصلي لديك
                'table_id' => $table1->id, 
            ]);
            
            // 2. إنشاء طلب سفري (Takeaway)
            // ❌ تصحيح: استخدام اسم العلاقة الموجود لديك: takeawayorders()
            $takeAwayOrder = $waiter->takeawayorders()->create([
                'order_number' => 'TAW001',
                'status' => 'ready',
                'total_amount' => 80.00, // ❌ تصحيح: استخدام الاسم الأصلي لديك
                'customer_name' => 'Sami',
                // 'customer_phone' => '0501234567', // يفضل إضافة رقم الهاتف
            ]);

            // 3. ربط تفاصيل الطلب (Order Items)
            $this->seedOrderItems($dineInOrder, $takeAwayOrder);
        }
    }
    
    // تابع مُساعد لإنشاء تفاصيل الطلبات (Order Items)
    private function seedOrderItems($dineInOrder, $takeAwayOrder)
    {
        $item1 = ItemsRestaurant::find(1); // نفترض وجود صنف
        $item2 = ItemsRestaurant::find(2); // نفترض وجود صنف

        if ($item1 && $item2) {
            
            // إضافة صنف للطلب الداخلي
            // ❌ تصحيح: استخدام اسم العلاقة الصحيح: orderItemsRestaurants()
            $dineInOrder->orderItemsRestaurants()->create([ 
                'item_id' => $item1->id,
                'quantity' => 2,
                'price' => 50.00,
                'subtotal' => 100.00, // ✅ إضافة subtotal
            ]);
            
            // إضافة صنف للطلب السفري
            // ❌ تصحيح: استخدام اسم العلاقة الصحيح: orderItemsRestaurants()
            $takeAwayOrder->orderItemsRestaurants()->create([
                'item_id' => $item2->id,
                'quantity' => 1,
                'price' => 80.00,
                'subtotal' => 80.00,
            ]);
        }
    }
}