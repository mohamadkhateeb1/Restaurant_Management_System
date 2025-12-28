<?php

namespace App\Http\Controllers;

use App\Models\InvetoryTransactions;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InvetoryTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $item = Inventory::findOrFail($id);
        return view('Pages.Inventory_Transaction.create', ['item' => $item]);
    }


    public function store(Request $request, $id)
    {


        $validated = $request->validate([
            'type'      => 'required|in:in,out,adjustment', // نوع الحركة (وارد/صادر/تعديل)
            'quantity'  => 'required|numeric|min:0.01',      // الكمية
            'reference' => 'nullable|string|max:255',      // رقم الفاتورة أو المرجع
            'notes'     => 'nullable|string',              // ملاحظات إضافية
        ]);

        $item = Inventory::findOrFail($id);

        if ($request->type == 'in') {
            $item->increment('quantity', $request->quantity);
        } elseif ($request->type == 'out') {
            if ($item->quantity < $request->quantity) {
                return back()->with('error', 'عذراً، الكمية المتوفرة في المخزن غير كافية (الرصيد الحالي: ' . $item->quantity . ')');
            }
            $item->decrement('quantity', $request->quantity);
        }

        $item->transactions()->create([
            'type'        => $request->type,
            'quantity'    => $request->quantity,
            'reference'   => $request->reference,
            'notes'       => $request->notes,
            'employee_id' => Auth::id(),
            'created_at'  => now(),
        ]);

        return redirect()->route('Pages.inventory.show', $item->id)
            ->with('success', 'تم تسجيل الحركة بنجاح وتحديث الرصيد الحالي إلى: ' . $item->quantity);
    }
}
