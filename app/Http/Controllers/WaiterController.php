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
     * عرض الصفحة الرئيسية للنادل
     */
    public function index(Request $request)
    {// جلب جميع الطاولات والأصناف والتصنيفات
        $tables = TablesRestaurant::all();
        $categories = CategoriesRestaurant::where('status', 'active')->get();
// تصفية الأصناف حسب التصنيف إذا تم التحديد
        $categoryId = $request->get('category_id');
        $items = ItemsRestaurant::where('status', 'available')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))// إضافة شرط تصفية حسب التصنيف
            ->get();
// تهيئة المتغيرات الافتراضية
        $selectedTable = null;
        $currentOrder = null;
        $draft = [];// مسودة الطلبات من الجلسة

        if ($request->has('table_id')) {// إذا تم اختيار طاولة معينة
            $selectedTable = TablesRestaurant::find($request->table_id);// جلب بيانات الطاولة المحددة
            
            // جلب الطلب المرسل مسبقاً (الموجود في قاعدة البيانات)
            $currentOrder = DineInOrderRestaurant::where('table_id', $request->table_id)
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->with('orderItems.item')
                ->first();

            // جلب "المسودة" الحالية من الجلسة (الأصناف التي لم تُرسل بعد)
            $draft = session()->get('waiter_draft_' . $request->table_id, []);
        }

        return view('Pages.Waiter.index', compact('tables', 'categories', 'items', 'selectedTable', 'currentOrder', 'draft'));
    }

    /**
     * إضافة صنف إلى مسودة الجلسة (Backend Session)
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
        return back();
    }

    /**
     * تحديث أو حذف صنف من المسودة
     */
    public function updateDraft(Request $request)
    {
        $cart = session()->get('waiter_draft_' . $request->table_id, []);
        $id = $request->item_id;

        if(isset($cart[$id])) {// التحقق من وجود الصنف في المسودة
            if($request->action == 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
        }

        session()->put('waiter_draft_' . $request->table_id, $cart);
        return back();
    }

    /**
     * إرسال الطلبات من المسودة (Session) إلى قاعدة البيانات (المطبخ)
     */
    public function storeOrder(Request $request)// تخزين الطلبات
    {
        $request->validate([
            'table_id' => 'required|exists:tables_restaurants,id',
        ]);

        // جلب الأصناف من الجلسة بدلاً من الـ Request لضمان الأمان
        $draftItems = session()->get('waiter_draft_' . $request->table_id, []);// جلب المسودة من الجلسة

        if (empty($draftItems)) {// التحقق من أن المسودة غير فارغة
            return back()->with('error', 'المسودة فارغة');
        }

        return DB::transaction(function () use ($request, $draftItems) {
            
            $order = DineInOrderRestaurant::where('table_id', $request->table_id)// جلب الطلب القائم للطاولة إذا وجد
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->first();

            if (!$order) {// إنشاء طلب جديد إذا لم يكن هناك طلب قائم
                $order = DineInOrderRestaurant::create([// إنشاء طلب جديد
                    'table_id'     => $request->table_id,// معرف الطاولة
                    'employee_id'  => Auth::id(),
                    'order_number' => 'DIN-' . strtoupper(uniqid()),
                    'status'       => 'pending',
                    'total_amount' => 0.00
                ]);

                TablesRestaurant::where('id', $request->table_id)->update(['status' => 'occupied']);// تحديث حالة الطاولة إلى مشغولة
            }

            foreach ($draftItems as $item) {// حفظ كل صنف في قاعدة البيانات
                OrderItemsRestaurant::create([
                    'dine_in_order_id' => $order->id,
                    'item_id'          => $item['id'],
                    'quantity'         => $item['quantity'],
                    'price'            => $item['price'],
                ]);
            }

            $order->refreshTotalAmount();
            $order->update(['status' => 'preparing']);

            // مسح المسودة من الجلسة بعد التخزين بنجاح
            session()->forget('waiter_draft_' . $request->table_id);

            return back()->with('success', 'تم إرسال الطلبات للمطبخ');
        });
    }

    /**
     * طلب الحساب (تحويل الحالة لـ ready ليراها الكاشير)
     */
    public function requestBill($id)
    {
        $order = DineInOrderRestaurant::findOrFail($id);
        $order->update(['status' => 'ready']);

        return back()->with('success', 'تم إرسال طلب الحساب للكاشير');
    }
}