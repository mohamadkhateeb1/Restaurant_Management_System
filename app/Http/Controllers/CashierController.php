<?php

namespace App\Http\Controllers;

use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use App\Models\OrderItemsRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\CategoriesRestaurant;
use App\Models\Invoice;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cachier;

class CashierController extends Controller
{
    /**
     * شاشة التحصيل الأساسية
     */
    public function index()
    {
        // تم التأكد من وجود with لجلب الأصناف للمعاينة والطباعة
        $pendingDineIn = DineInOrderRestaurant::where('status', 'ready')
            ->with(['table', 'orderItems.item'])
            ->get();

        return view('Pages.Cashier.index', compact('pendingDineIn'));
    }

    /**
     * دفع فاتورة طاولة
     */
    public function payDineIn(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $order = DineInOrderRestaurant::with(['orderItems.item.inventory', 'table'])->findOrFail($request->order_id);

            foreach ($order->orderItems as $orderItem) {
                $item = $orderItem->item;
                if ($item && $item->inventory) {
                    $item->inventory->decrement('quantity', $orderItem->quantity);

                    InventoryTransaction::create([
                        'inventory_id' => $item->inventory->id,
                        'employee_id'  => Auth::id(),
                        'type'         => 'out',
                        'quantity'     => $orderItem->quantity,
                        'reference'    => 'بيع طاولة رقم: ' . ($order->table->table_number ?? $order->id),
                    ]);
                }
            }

            Invoice::create([
                'invoice_number'    => 'INV-D-' . time() . rand(10, 99),
                'dine_in_order_id'  => $order->id,
                'employee_id'       => Auth::id(),
                'amount_paid'       => $order->total_amount,
                'payment_status'    => 'paid',
            ]);

            $order->update(['status' => 'paid']);
            if ($order->table) {
                $order->Table->update(['status' => 'available']);
            }

            return back()->with('success', 'تم قبض فاتورة الطاولة بنجاح');
        });
    }

    public function create(Request $request)
    {
        $categories = CategoriesRestaurant::where('status', 'active')->get();
        $query = ItemsRestaurant::where('status', 'available');
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $items = $query->get();
        $cart = session()->get('pos_cart', []);
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);
        return view('Pages.Cashier.create', compact('items', 'categories', 'cart', 'total'));
    }

    public function addToSessionCart(Request $request)
    {
        $id = $request->id;
        $dbItem = ItemsRestaurant::findOrFail($id);
        $cart = session()->get('pos_cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = ["id" => $dbItem->id, "name" => $dbItem->item_name, "qty" => 1, "price" => $dbItem->price];
        }
        session()->put('pos_cart', $cart);
        return back()->with('success', 'تم إضافة ' . $dbItem->item_name);
    }

    public function storeTakeaway(Request $request)
    {
        $cart = session()->get('pos_cart', []);
        if (empty($cart)) return back()->with('error', 'السلة فارغة');
        return DB::transaction(function () use ($request, $cart) {
            $order = TakeAwaysRestaurant::create([
                'employee_id'   => Auth::id(),
                'order_number'  => 'TAKE-' . time(),
                'customer_name' => $request->customer_name ?? 'زبون سفري',
                'status'        => 'paid',
                'total_amount'  => 0
            ]);
            $total = 0;
            foreach ($cart as $itemInCart) {
                OrderItemsRestaurant::create([
                    'take_away_order_id' => $order->id,
                    'item_id'            => $itemInCart['id'],
                    'quantity'           => $itemInCart['qty'],
                    'price'              => $itemInCart['price'],
                ]);
                $dbItem = ItemsRestaurant::with('inventory')->find($itemInCart['id']);
                if ($dbItem && $dbItem->inventory) {
                    $dbItem->inventory->decrement('quantity', $itemInCart['qty']);
                    InventoryTransaction::create([
                        'inventory_id' => $dbItem->inventory->id,
                        'employee_id'  => Auth::id(),
                        'type'         => 'out',
                        'quantity'     => $itemInCart['qty'],
                        'reference'    => 'بيع سفري طلب: ' . $order->order_number,
                    ]);
                }
                $total += ($itemInCart['price'] * $itemInCart['qty']);
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
            return redirect()->route('Pages.cashier.index')->with('success', 'تم تسجيل طلب السفري بنجاح');
        });
    }

    public function invoicesIndex(Request $request)
    {
        $query = Invoice::with(['dineInOrder.table', 'takeawayOrder', 'employee']);
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            $query->whereDate('created_at', now()->toDateString());
        }
        $invoices = $query->orderBy('created_at', 'desc')->paginate(12);
        return view('Pages.Cashier.invoice', compact('invoices'));
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::with(['dineInOrder.table', 'dineInOrder.orderItems.item', 'takeawayOrder.orderItems.item', 'employee'])->findOrFail($id);
        return view('Pages.Cashier.showinvoice', compact('invoice'));
    }

    public function removeFromSessionCart($id)
    {
        $cart = session()->get('pos_cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('pos_cart', $cart);
        }
        return back()->with('info', 'تم إزالة الصنف');
    }

    public function clearSessionCart()
    {
        session()->forget('pos_cart');
        return back()->with('info', 'تم تفريغ السلة');
    }

    public function undoLastTakeaway()
    {
        return DB::transaction(function () {
            $lastTakeawayInvoice = Invoice::whereNotNull('takeaway_order_id')->with(['takeawayOrder.orderItems.item.inventory'])->latest()->first();
            if (!$lastTakeawayInvoice) return back()->with('error', 'لا توجد فواتير!');
            $order = $lastTakeawayInvoice->takeawayOrder;
            if ($order) {
                foreach ($order->orderItems as $orderItem) {
                    $item = $orderItem->item;
                    if ($item && $item->inventory) {
                        $item->inventory->increment('quantity', $orderItem->quantity);
                        InventoryTransaction::create([
                            'inventory_id' => $item->inventory->id,
                            'employee_id'  => Auth::id(),
                            'type'         => 'in',
                            'quantity'     => $orderItem->quantity,
                            'reference'    => 'مرتجع سفري - طلب رقم: ' . $order->order_number,
                        ]);
                    }
                }
                $order->orderItems()->delete();
                $order->delete();
            }
            $lastTakeawayInvoice->delete();
            return redirect()->route('Pages.cashier.index')->with('success', 'تم إلغاء آخر طلب سفري');
        });
    }
}
