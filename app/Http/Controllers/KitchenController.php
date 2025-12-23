<?php

namespace App\Http\Controllers;

use App\Models\DineInOrderRestaurant;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        // جلب الطلبات التي لم تنتهِ بعد (انتظار أو تحضير)
        $orders = DineInOrderRestaurant::whereIn('status', ['pending', 'preparing'])
            ->with(['table', 'orderItems.item'])
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('Pages.Kitchen.index', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        $order = DineInOrderRestaurant::findOrFail($request->order_id);
        $newStatus = $request->status; // سنستقبل الحالة الجديدة من الزر

        if (in_array($newStatus, ['preparing', 'ready'])) {
            $order->update(['status' => $newStatus]);
        }

        return back()->with('success', 'تم تحديث حالة الطلب');
    }
}