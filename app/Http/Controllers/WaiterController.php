<?php

namespace App\Http\Controllers;

use App\Models\DineInOrderRestaurant;
use App\Models\OrderItemsRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\TablesRestaurant;
use App\Models\CategoriesRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaiterController extends Controller
{
    /**
     * عرض الصفحة الرئيسية للنادل بنظام النيون المظلم
     */
    public function index(Request $request)
    {
        $tables = TablesRestaurant::all();
        $categories = CategoriesRestaurant::where('status', 'active')->get();

        $categoryId = $request->get('category_id');
        // جلب الأصناف مع علاقة المخزن لعرض الكمية المتاحة للنادل قبل الطلب
        $items = ItemsRestaurant::where('status', 'available')
            ->with('inventory')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->get();

        $selectedTable = null;
        $currentOrder = null;
        $draft = [];

        if ($request->has('table_id')) {
            $selectedTable = TablesRestaurant::find($request->table_id);
            
            // جلب الطلبات النشطة (قيد الانتظار، قيد التحضير، أو جاهزة)
            $currentOrder = DineInOrderRestaurant::where('table_id', $request->table_id)
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->with('orderItems.item')
                ->first();

            $draft = session()->get('waiter_draft_' . $request->table_id, []);
        }

        return view('Pages.Waiter.index', compact('tables', 'categories', 'items', 'selectedTable', 'currentOrder', 'draft'));
    }

    /**
     * إضافة صنف لمسودة الطاولة (Session)
     */
    public function addToDraft(Request $request)
    {
        $request->validate([
            'table_id' => 'required',
            'item_id' => 'required|exists:items_restaurants,id'
        ]);

        $cart = session()->get('waiter_draft_' . $request->table_id, []);
        $id = $request->item_id;

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $item = ItemsRestaurant::find($id);
            $cart[$id] = [
                "id" => $item->id,
                "name" => $item->item_name,
                "quantity" => 1,
                "price" => $item->price
            ];
        }

        session()->put('waiter_draft_' . $request->table_id, $cart);
        return back()->with('success', 'تمت الإضافة للمسودة');
    }

    /**
     * إرسال الطلبات للمطبخ وتثبيتها في قاعدة البيانات
     */
    public function storeOrder(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables_restaurants,id',
        ]);

        $draftItems = session()->get('waiter_draft_' . $request->table_id, []);

        if (empty($draftItems)) {
            return back()->with('error', 'يجب إضافة أصناف للمسودة أولاً');
        }

        return DB::transaction(function () use ($request, $draftItems) {
            
            // البحث عن طلب قائم أو إنشاء واحد جديد
            $order = DineInOrderRestaurant::where('table_id', $request->table_id)
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->first();

            if (!$order) {
                $order = DineInOrderRestaurant::create([
                    'table_id'     => $request->table_id,
                    'employee_id'  => Auth::id(),
                    'order_number' => 'DIN-' . strtoupper(uniqid()),
                    'status'       => 'pending',
                    'total_amount' => 0.00
                ]);

                TablesRestaurant::where('id', $request->table_id)->update(['status' => 'occupied']);
            }

            // تخزين العناصر مع تثبيت السعر الحالي
            foreach ($draftItems as $item) {
                OrderItemsRestaurant::create([
                    'dine_in_order_id' => $order->id,
                    'item_id'          => $item['id'],
                    'quantity'         => $item['quantity'],
                    'price'            => $item['price'], // السعر الثابت وقت الطلب
                ]);
            }

            // تحديث إجمالي الطلب وتغيير الحالة للمطبخ
            $order->refreshTotalAmount();
            $order->update(['status' => 'preparing']);

            session()->forget('waiter_draft_' . $request->table_id);

            return back()->with('success', 'تم إرسال الطلب للمطبخ بنجاح');
        });
    }

   public function updateDraft() {
    $tableId = request()->table_id;
    $itemId = request()->item_id;
    $action = request()->action; // سنضيف متغير "الأكشن" لنعرف إذا كان المطلوب زيادة أو نقصان

    $cart = session()->get('waiter_draft_' . $tableId, []);

    if(isset($cart[$itemId])) {
        if($action == 'decrease') {
            // ينقص واحد من الكمية الموجودة أصلاً
            $cart[$itemId]['quantity'] -= 1;
        } else {
            // في حال أردت استخدام نفس الدالة للزيادة
            $cart[$itemId]['quantity'] += 1;
        }

        // إذا وصلت الكمية لصفر أو أقل، احذف الصنف نهائياً
        if($cart[$itemId]['quantity'] <= 0) {
            unset($cart[$itemId]);
        }

        session()->put('waiter_draft_' . $tableId, $cart);
    }

    return back()->with('success', 'تم تحديث المسودة بنجاح');
}

    /**
     * طلب الحساب (جاهز للدفع)
     */
    public function requestBill($id)
    {
        $order = DineInOrderRestaurant::findOrFail($id);
        // تحويل الحالة إلى ready ليراها الكاشير في لوحة التحصيل
        $order->update(['status' => 'ready']);

        return back()->with('success', 'تم تنبيه الكاشير لطلب الحساب');
    }
}