<?php

namespace App\Http\Controllers;

use App\Models\TablesRestaurant;
use Illuminate\Http\Request;

class TablesRestaurantController extends Controller
{
public function index(Request $request)
{
    // 1. نبدأ ببناء الاستعلام (Query Builder)
    $query = TablesRestaurant::query();

    // 2. جلب قيم الفلترة من الرابط (Query Parameters)
    $location = $request->query('location');
    $status = $request->query('status');

    // 3. تطبيق الفلترة حسب الموقع (إذا كان موجوداً)
    if ($location) {
        $query->where('location', $location);
    }

    // 4. تطبيق الفلترة حسب الحالة (إذا كانت موجودة)
    if ($status) {
        $query->where('status', $status);
    }

    // 5. جلب الطاولات مرتبة رقمياً مع الترقيم (Pagination)
    // استخدمنا paginate ليدعم التنقل بين الصفحات كما في الأصناف
    $tables = $query->orderBy('table_number', 'asc')->paginate(12);

    // 6. حساب الإحصائيات (تُحسب من قاعدة البيانات مباشرة لتكون دقيقة)
    $stats = [
        'total'     => TablesRestaurant::count(),
        'available' => TablesRestaurant::where('status', 'available')->count(),
        'occupied'  => TablesRestaurant::where('status', 'occupied')->count(),
        'reserved'  => TablesRestaurant::where('status', 'reserved')->count(),
    ];

    return view('Pages.Tables.index', compact('tables', 'stats'));
}
    public function create()
    {
        return view('Pages.Tables.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:tables_restaurants,table_number',
            'seating_capacity' => 'required|integer|min:1',
            'location' => 'nullable|string'
        ]);

        TablesRestaurant::create([
            'table_number' => $request->table_number,
            'seating_capacity' => $request->seating_capacity,
            'location' => $request->location, 
            'status' => 'available'
        ]);

        return redirect()->route('Pages.Tables.index')->with('success', 'تمت إضافة الطاولة بنجاح.');
    }
    public function edit($id)
    {
        $table = TablesRestaurant::findOrFail($id);
        return view('Pages.Tables.edit', compact('table'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'table_number' => 'required|unique:tables_restaurants,table_number,' . $id,
            'seating_capacity' => 'required|integer|min:1',
            'location' => 'nullable|string',
            'status' => 'required|in:available,occupied,reserved'
        ]);
        $table = TablesRestaurant::findOrFail($id);
        $table->update([
            'table_number' => $request->table_number,
            'seating_capacity' => $request->seating_capacity,
            'location' => $request->location,
            'status' => $request->status
        ]);
        return redirect()->route('Pages.Tables.index')->with('success', 'تم تحديث بيانات الطاولة بنجاح.');
    }
    public function destroy($id)
    {
        $table = TablesRestaurant::findOrFail($id);
        $table->delete();
        return redirect()->route('Pages.Tables.index')->with('success', 'تم حذف الطاولة بنجاح.');
    }
    public function bulkDestroy(Request $request)
{
    $query = TablesRestaurant::query();

    // إذا أردت حذف المفلتر فقط، نطبق الشروط هنا
    if ($request->location) {
        $query->where('location', $request->location);
    }
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $count = $query->count();
    $query->delete();

    return redirect()->route('Pages.Tables.index')->with('success', "تم حذف $count طاولة بنجاح.");
}
}
