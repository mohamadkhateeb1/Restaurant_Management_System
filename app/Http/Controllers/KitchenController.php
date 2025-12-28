<?php

namespace App\Http\Controllers;

use App\Models\DineInOrderRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Kitchen;
class KitchenController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Kitchen::class);
        $orders = DineInOrderRestaurant::whereIn('status', ['pending', 'preparing'])
            ->with(['table', 'orderItems.item'])
            ->orderBy('updated_at', 'asc')
            ->get();
        return view('Pages.Kitchen.index', compact('orders'));
    }
    public function updateStatus(Request $request)
    {
        $order = DineInOrderRestaurant::findOrFail($request->order_id);
        $newStatus = $request->status;
        if (in_array($newStatus, ['preparing', 'ready'])) {
            $order->update(['status' => $newStatus]);
        }
        return back()->with('success', 'تم تحديث حالة الطلب');
    }
}
