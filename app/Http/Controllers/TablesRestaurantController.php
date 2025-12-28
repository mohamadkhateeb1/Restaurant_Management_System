<?php

namespace App\Http\Controllers;

use App\Models\TablesRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TablesRestaurantController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', TablesRestaurant::class);
        $query = TablesRestaurant::query();
        $location = $request->query('location');
        $status = $request->query('status');
        if ($location) {
            $query->where('location', $location);
        }
        if ($status) {
            $query->where('status', $status);
        }
        $tables = $query->orderBy('table_number', 'asc')->paginate(12);
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
