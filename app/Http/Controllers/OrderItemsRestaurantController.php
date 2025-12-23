<?php

namespace App\Http\Controllers;

use App\Models\OrderItemsRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use Illuminate\Http\Request;

class OrderItemsRestaurantController extends Controller
{
    /**
     * عرض تفاصيل الطلب الكاملة (أصناف + بيانات الفاتورة)
     */
public function index(Request $request)
{
    $dine_in_id = $request->get('dine_in_id');
    $takeaway_id = $request->get('takeaway_id');

    // جلب العناصر مع العلاقات
    $items = OrderItemsRestaurant::with(['item', 'dineInOrder', 'takeawayOrder'])
        ->when($dine_in_id, fn($q) => $q->where('dine_in_order_id', $dine_in_id))
        ->when($takeaway_id, fn($q) => $q->where('takeaway_order_id', $takeaway_id))
        ->get();

    // تعريف المتغير وإرساله لتجنب الخطأ
    $orderInfo = null;
    if ($dine_in_id) {
        $orderInfo = \App\Models\DineInOrderRestaurant::with(['table', 'employee'])->find($dine_in_id);
    }

    return view('Pages.OrderItems.index', compact('items', 'dine_in_id', 'takeaway_id', 'orderInfo'));
}

    /**
     * إضافة صنف للطلب مع تثبيت السعر
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items_restaurants,id',
            'quantity' => 'required|integer|min:1',
            'dine_in_order_id' => 'nullable|exists:dine_in_order_restaurants,id',
            'takeaway_order_id' => 'nullable|exists:take_aways_restaurants,id',
        ]);

        // جلب سعر الصنف الحالي من المنيو لتخزينه في المخزون/الفاتورة
        $menuItem = ItemsRestaurant::findOrFail($request->item_id);
        $validated['price'] = $menuItem->price; 

        OrderItemsRestaurant::create($validated);

        return back()->with('success', 'تم إضافة الصنف للطلب وتحديث البيانات');
    }

    /**
     * حذف صنف من الفاتورة
     */
    public function destroy($id)
    {
        $orderItem = OrderItemsRestaurant::findOrFail($id);
        $orderItem->delete();

        return back()->with('success', 'تم إزالة الصنف من الطلب بنجاح');
    }
}