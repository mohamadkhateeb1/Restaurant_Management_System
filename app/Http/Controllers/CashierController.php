<?php

namespace App\Http\Controllers;

use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use App\Models\OrderItemsRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\CategoriesRestaurant;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /**
     * شاشة التحصيل (دفع فواتير الطاولات الجاهزة)
     */
    public function index()
    {
        $pendingDineIn = DineInOrderRestaurant::where('status', 'ready')
            ->with(['table', 'orderItems.item'])
            ->get();

        return view('Pages.Cashier.index', compact('pendingDineIn'));
    }

    /**
     * شاشة طلب سفري جديد (POS) مع ميزة الفلترة
     */
    public function create(Request $request)
    {
        // 1. جلب جميع الأقسام لعرضها في قائمة الفلترة
        $categories = CategoriesRestaurant::where('status', 'active')->get();

        // 2. بناء استعلام الأصناف مع إمكانية الفلترة حسب القسم
        $query = ItemsRestaurant::where('status', 'available');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->get();

        // 3. إدارة السلة من الجلسة
        $cart = session()->get('pos_cart', []);

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);

        return view('Pages.Cashier.create', compact('items', 'categories', 'cart', 'total'));
    }

    /**
     * إضافة صنف إلى سلة الجلسة
     */
    public function addToSessionCart(Request $request)
    {
        $id = $request->id; // جلب معرف الصنف من الطلب
        $dbItem = ItemsRestaurant::findOrFail($id); // جلب الصنف من قاعدة البيانات
        $cart = session()->get('pos_cart', []); // جلب السلة من الجلسة

        if (isset($cart[$id])) { // التحقق من وجود الصنف في السلة
            $cart[$id]['qty']++; // زيادة الكمية بمقدار 1
        } else { // إذا لم يكن الصنف موجودًا في السلة
            $cart[$id] = [ // إضافة الصنف إلى السلة
                "id" => $dbItem->id, // معرف الصنف
                "name" => $dbItem->item_name, // اسم الصنف
                "qty" => 1, // الكمية الافتراضية
                "price" => $dbItem->price // سعر الصنف
            ];
        }

        session()->put('pos_cart', $cart);
        return back()->with('success', 'تم إضافة ' . $dbItem->item_name);
    }

    /**
     * حذف صنف محدد من سلة الجلسة
     */
    public function removeFromSessionCart($id) // إزالة صنف من السلة
    {
        $cart = session()->get('pos_cart', []); // جلب السلة من الجلسة

        if (isset($cart[$id])) { // التحقق من وجود الصنف في السلة
            unset($cart[$id]); // إزالة الصنف من السلة
            session()->put('pos_cart', $cart); // تحديث السلة في الجلسة
        }

        return back()->with('info', 'تم إزالة الصنف من السلة');
    }

    /**
     * تفريغ السلة بالكامل
     */
    public function clearSessionCart() // تفريغ السلة
    {
        session()->forget('pos_cart');
        return back()->with('info', 'تم تفريغ السلة بالكامل');
    }

    /**
     * دفع فاتورة طاولة (Dine-In) قادمة من النادل
     */
    public function payDineIn(Request $request) // دفع فاتورة طاولة
    {
        return DB::transaction(function () use ($request) { // بدء معاملة قاعدة البيانات
            //transaction; تنفيذ جميع العمليات التالية كوحدة واحدة
            $order = DineInOrderRestaurant::findOrFail($request->order_id);

            Invoice::create([
                'invoice_number'    => 'INV-D-' . time() . rand(10, 99), // إنشاء فاتورة جديدة
                // rand: توليد رقم عشوائي لضمان تفرد رقم الفاتورة
                //time(): الحصول على الطابع الزمني الحالي
                'dine_in_order_id'  => $order->id,
                'employee_id'       => Auth::id(),
                'amount_paid'       => $order->total_amount,
                'payment_status'    => 'paid',
            ]);

            $order->update(['status' => 'paid']);
            $order->table->update(['status' => 'available']);

            return back()->with('success', 'تم قبض فاتورة الطاولة بنجاح'); // إتمام المعاملة بنجاح
        });
    }

    /**
     * حفظ طلب سفري جديد (POS)
     */
    public function storeTakeaway(Request $request)
    {
        $cart = session()->get('pos_cart', []);
        if (empty($cart)) return back()->with('error', 'لا يمكن إتمام الطلب والسلة فارغة'); // التحقق من أن السلة غير فارغة

        return DB::transaction(function () use ($request, $cart) { // بدء معاملة قاعدة البيانات
            $order = TakeAwaysRestaurant::create([ // إنشاء طلب سفري جديد
                'employee_id'   => Auth::id(),
                'order_number'  => 'TAKE-' . time(),
                'customer_name' => $request->customer_name ?? 'زبون سفري',
                'status'        => 'pending',
                'total_amount'  => 0
            ]);

            $total = 0;
            foreach ($cart as $item) {
                OrderItemsRestaurant::create([
                    'take_away_order_id' => $order->id,
                    'item_id'            => $item['id'],
                    'quantity'           => $item['qty'],
                    'price'              => $item['price'],
                ]);
                $total += ($item['price'] * $item['qty']);
            }
            $order->update(['total_amount' => $total]);

            Invoice::create([
                'invoice_number'    => 'INV-T-' . time(),
                'takeaway_order_id' => $order->id,
                'employee_id'       => Auth::id(),
                'amount_paid'       => $total,
                'payment_status'    => 'paid',
            ]);

            session()->forget('pos_cart');

            return redirect()->route('Pages.cashier.index')->with('success', 'تم تسجيل طلب السفري وإصدار الفاتورة');
        });
    }

    public function createTakeaway() // إعادة توجيه إلى شاشة طلب سفري جديد (POS)
    {
        return redirect()->route('Pages.cashier.create');
    }
    // شاشة عرض الفواتير مع ميزة الفلترة حسب التاريخ
   public function invoicesIndex(Request $request)
{
    $query = Invoice::with(['dineInOrder.table', 'takeawayOrder', 'employee']);
// بناء استعلام الفواتير مع العلاقات الضرورية
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    } else {
        $query->whereDate('created_at', now()->toDateString());
    }

    $invoices = $query->orderBy('created_at', 'desc')->paginate(12);

    return view('Pages.Cashier.invoice', compact('invoices'));
}
// شاشة عرض تفاصيل فاتورة محددة
public function showInvoice($id)
{
    // جلب الفاتورة مع كافة العلاقات الضرورية
    $invoice = Invoice::with([
        'dineInOrder.table', 
        'dineInOrder.orderItems.item', 
        'takeawayOrder.orderItems.item', 
        'employee'
    ])->findOrFail($id);

    // إرسال البيانات لصفحة عرض مخصصة
    return view('Pages.Cashier.showinvoice', compact('invoice'));
}
}
