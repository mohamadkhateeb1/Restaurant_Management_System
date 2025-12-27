<?php

namespace App\Http\Controllers;

use App\Models\InvetoryTransactions;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class InvetoryTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $item = Inventory::findOrFail($id);
        return view('Pages.Inventory_Transaction.create', ['item' => $item]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'type'      => 'required|in:in,out,adjustment', // نوع الحركة (وارد/صادر/تعديل)
            'quantity'  => 'required|numeric|min:0.01',      // الكمية
            'reference' => 'nullable|string|max:255',      // رقم الفاتورة أو المرجع
            'notes'     => 'nullable|string',              // ملاحظات إضافية
        ]);

        // 2. جلب المادة من المخزن باستخدام الـ ID
        $item = Inventory::findOrFail($id);

        // 3. معالجة الحسابات لتحديث رصيد المخزن (الـ 100 تصبح 98 في حال الـ out)
        if ($request->type == 'in') {
            // إضافة للرصيد في حال كان "وارد"
            $item->increment('quantity', $request->quantity);
        } elseif ($request->type == 'out') {
            // التحقق أولاً: هل الرصيد كافٍ للخصم؟
            if ($item->quantity < $request->quantity) {
                return back()->with('error', 'عذراً، الكمية المتوفرة في المخزن غير كافية (الرصيد الحالي: ' . $item->quantity . ')');
            }
            // خصم من الرصيد في حال كان "صادر" (بيع مثلاً)
            $item->decrement('quantity', $request->quantity);
        }
        // ملاحظة: في حالة adjustment (تعديل)، يمكنك إضافة منطق خاص أو تحديث يدوي للرصيد

        // 4. تسجيل العملية في جدول حركات المخزون للتوثيق
        $item->transactions()->create([
            'type'        => $request->type,
            'quantity'    => $request->quantity,
            'reference'   => $request->reference,
            'notes'       => $request->notes,
            'employee_id' => Auth::id(), // تسجيل الموظف الذي قام بالحركة
            'created_at'  => now(),        // توثيق وقت الحركة
        ]);

        // 5. إعادة التوجيه لصفحة عرض المادة مع رسالة نجاح
        return redirect()->route('Pages.inventory.show', $item->id)
            ->with('success', 'تم تسجيل الحركة بنجاح وتحديث الرصيد الحالي إلى: ' . $item->quantity);
    }

    /**
     * Display the specified resource.
     */
    public function show($invetoryTransactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($invetoryTransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $invetoryTransactions)
    {
        //
    }


    // public function destroy($id)
    // {
    //     $transaction = InvetoryTransactions::findOrFail($id);
    //     $item = Inventory::findOrFail($transaction->inventory_id);
    // }
}
