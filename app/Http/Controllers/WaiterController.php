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
use Illuminate\Support\Facades\Gate;

class WaiterController extends Controller
{
    public function index(Request $request)
    {
        $tables = TablesRestaurant::all();
        $categories = CategoriesRestaurant::where('status', 'active')->get();
        $categoryId = $request->get('category_id');
        $items = ItemsRestaurant::where('status', 'available')
            ->with('inventory')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->get();
        $selectedTable = null;
        $currentOrder = null;
        $draft = [];
        if ($request->has('table_id')) {
            $selectedTable = TablesRestaurant::find($request->table_id);
            $currentOrder = DineInOrderRestaurant::where('table_id', $request->table_id)
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->with('orderItems.item')
                ->first();
            $draft = session()->get('waiter_draft_' . $request->table_id, []);
        }
        return view('Pages.Waiter.index', compact('tables', 'categories', 'items', 'selectedTable', 'currentOrder', 'draft'));
    }
    public function addToDraft(Request $request)
    {
        $request->validate([
            'table_id' => 'required',
            'item_id' => 'required|exists:items_restaurants,id'
        ]);
        $cart = session()->get('waiter_draft_' . $request->table_id, []);
        $id = $request->item_id;
        if (isset($cart[$id])) {
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
            $order = DineInOrderRestaurant::where('table_id', $request->table_id)
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->first();
            if (!$order) {
                $order = DineInOrderRestaurant::create([
                    'table_id'     => $request->table_id,
                    'employee_id'  => Auth::id(), // يستخدم Guard الموظفين تلقائياً
                    'order_number' => 'DIN-' . strtoupper(uniqid()),
                    'status'       => 'pending',
                    'total_amount' => 0.00
                ]);
                TablesRestaurant::where('id', $request->table_id)->update(['status' => 'occupied']);
            }
            foreach ($draftItems as $item) {
                OrderItemsRestaurant::create([
                    'dine_in_order_id' => $order->id,
                    'item_id'          => $item['id'],
                    'quantity'         => $item['quantity'],
                    'price'            => $item['price'], // السعر الثابت وقت الطلب
                ]);
            }
            $order->refreshTotalAmount();
            $order->update(['status' => 'preparing']);
            session()->forget('waiter_draft_' . $request->table_id);
            return back()->with('success', 'تم إرسال الطلب للمطبخ بنجاح');
        });
    }
    public function updateDraft()
    {
        $tableId = request()->table_id;
        $itemId = request()->item_id;
        $action = request()->action;
        $cart = session()->get('waiter_draft_' . $tableId, []);
        if (isset($cart[$itemId])) {
            if ($action == 'decrease') {
                $cart[$itemId]['quantity'] -= 1;
            } else {
                $cart[$itemId]['quantity'] += 1;
            }
            if ($cart[$itemId]['quantity'] <= 0) {
                unset($cart[$itemId]);
            }
            session()->put('waiter_draft_' . $tableId, $cart);
        }
        return back()->with('success', 'تم تحديث المسودة بنجاح');
    }
    public function requestBill($id)
    {
        $order = DineInOrderRestaurant::findOrFail($id);
        $order->update(['status' => 'ready']);
        return back()->with('success', 'تم تنبيه الكاشير لطلب الحساب');
    }
}
