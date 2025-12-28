<?php

namespace App\Http\Controllers;

use App\Models\OrderItemsRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\DineInOrderRestaurant;
use App\Models\TakeAwaysRestaurant;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderItemsRestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['dineInOrder', 'takeawayOrder', 'employee']);
        if ($request->has('type')) {
            if ($request->type == 'dine_in') {
                $query->whereNotNull('dine_in_order_id');
            } elseif ($request->type == 'takeaway') {
                $query->whereNotNull('takeaway_order_id');
            }
        }
        $records = $query->orderBy('created_at', 'desc')->get();
        return view('Pages.OrderItems.index', compact('records'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items_restaurants,id',
            'quantity' => 'required|integer|min:1',
            'dine_in_order_id' => 'nullable|exists:dine_in_order_restaurants,id',
            'take_away_order_id' => 'nullable|exists:take_aways_restaurants,id',
        ]);
        $menuItem = ItemsRestaurant::findOrFail($request->item_id);
        $validated['price'] = $menuItem->price;
        OrderItemsRestaurant::create($validated);
        return back()->with('success', 'تم إضافة ' . $menuItem->item_name . ' للطلب بنجاح');
    }

    public function destroy($id)
    {
        $orderItem = OrderItemsRestaurant::findOrFail($id);
        $orderItem->delete();
        return back()->with('info', 'تم تحديث محتويات الطلب وإزالة الصنف');
    }
}
