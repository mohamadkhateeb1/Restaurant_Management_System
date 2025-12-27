<?php

namespace App\Http\Controllers;

use App\Models\OrderItemsRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use App\Models\Invoice; // تأكد من استدعاء موديل الفواتير
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemsRestaurantController extends Controller
{
    /**
     * عرض سجل الأرشيف والجرد المالي (قائمة الفواتير)
     */
   public function index(Request $request)
{
    // البدء باستعلام أساسي مع العلاقات
    $query = Invoice::with(['dineInOrder', 'takeawayOrder', 'employee']);

    // الفلترة حسب النوع
    if ($request->has('type')) {
        if ($request->type == 'dine_in') {
            // طلبات الصالة: حيث معرّف طلب الصالة ليس فارغاً
            $query->whereNotNull('dine_in_order_id');
        } elseif ($request->type == 'takeaway') {
            // طلبات السفري: حيث معرّف طلب السفري ليس فارغاً
            $query->whereNotNull('takeaway_order_id');
        }
    }

    $records = $query->orderBy('created_at', 'desc')->get();

    return view('Pages.OrderItems.index', compact('records'));
}

    /**
     * إضافة صنف وتثبيت السعر وقت الطلب (لحماية الفاتورة من تغير الأسعار لاحقاً)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items_restaurants,id',
            'quantity' => 'required|integer|min:1',
            'dine_in_order_id' => 'nullable|exists:dine_in_order_restaurants,id',
            'take_away_order_id' => 'nullable|exists:take_aways_restaurants,id',
        ]);

        // جلب سعر الصنف الحالي من المنيو
        $menuItem = ItemsRestaurant::findOrFail($request->item_id);
        $validated['price'] = $menuItem->price; 

        // تسجيل الصنف في الفاتورة
        OrderItemsRestaurant::create($validated);

        return back()->with('success', 'تم إضافة ' . $menuItem->item_name . ' للطلب بنجاح');
    }

    /**
     * حذف صنف
     */
    public function destroy($id)
    {
        $orderItem = OrderItemsRestaurant::findOrFail($id);
        $orderItem->delete();

        return back()->with('info', 'تم تحديث محتويات الطلب وإزالة الصنف');
    }
}