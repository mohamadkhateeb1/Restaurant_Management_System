<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ItemsRestaurantController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', ItemsRestaurant::class);
        $categories = CategoriesRestaurant::where('is_menu_category', true)->get();
        $query = ItemsRestaurant::with(['category', 'inventory']);
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $items = $query->latest()->get();
        return view('Pages.Items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = CategoriesRestaurant::where('is_menu_category', true)->where('status', 'active')->get();
        $available_inventory = Inventory::where('item_type', 'menu_item')
            ->whereDoesntHave('item')
            ->get();
        $item = new ItemsRestaurant();
        return view('Pages.Items.create', compact('categories', 'item', 'available_inventory'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'inventory_id' => 'required|exists:inventories,id|unique:items_restaurants,inventory_id',
            'price'        => 'required|numeric|min:0',
            'status'       => 'required|in:available,unavailable',
        ]);
        return DB::transaction(function () use ($request) {
            $inventory = Inventory::findOrFail($request->inventory_id);
            $item = new ItemsRestaurant();
            $item->inventory_id = $inventory->id;
            $item->category_id  = $inventory->category_id;
            $item->item_name    = $inventory->name;
            $item->price        = $request->price;
            $item->description  = $request->description;
            $item->status       = $inventory->quantity > 0 ? $request->status : 'unavailable';
            $item->prepare_time = $request->prepare_time;
            $item->image        = $inventory->image;
            $item->save();
            return redirect()->route('Pages.Items.index')->with('success', 'تم ربط الصنف بالمخزن بنجاح.');
        });
    }

    public function update(Request $request, $id)
    {
        $item = ItemsRestaurant::findOrFail($id);
        $request->validate([
            'price'  => 'required|numeric|min:0',
            'status' => 'required|in:available,unavailable',
        ]);
        return DB::transaction(function () use ($request, $item) {
            $item->price        = $request->price;
            $item->description  = $request->description;
            $item->status       = ($item->inventory->quantity > 0) ? $request->status : 'unavailable';
            $item->prepare_time = $request->prepare_time;
            $item->item_name    = $item->inventory->name;
            $item->image = $item->inventory->image;
            $item->save();
            return redirect()->route('Pages.Items.index')->with('success', 'تم تحديث البيانات والمزامنة.');
        });
    }
    public function destroy($id)
    {
        $item = ItemsRestaurant::findOrFail($id);
        $item->delete();
        return redirect()->route('Pages.Items.index')->with('success', 'تمت إزالة الطبق من المنيو.');
    }
    public function show($id)
    {
        $item = ItemsRestaurant::with(['category', 'inventory'])->findOrFail($id);
        return view('Pages.Items.show', compact('item'));
    }
    public function edit($id)
    {
        $item = ItemsRestaurant::findOrFail($id);
        $categories = CategoriesRestaurant::where('is_menu_category', true)->where('status', 'active')->get();
        return view('Pages.Items.edit', compact('item', 'categories'));
    }
}
