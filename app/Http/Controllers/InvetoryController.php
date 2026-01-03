<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\CategoriesRestaurant;
use App\Models\ItemsRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class InvetoryController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', Inventory::class);
        $categories = CategoriesRestaurant::all();
        $query = Inventory::with(['category', 'item']); 

        if ($request->filled('item_type')) {
            $query->where('item_type', $request->item_type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->status == 'low_stock') {
            $query->whereRaw('quantity <= min_quantity');
        }

        $items = $query->latest()->get();
        return view('Pages.Inventory.index', compact('items', 'categories'));
    }

    public function create()
    {

        $categories = CategoriesRestaurant::where('status', 'active')->get();
        return view('Pages.Inventory.create', compact('categories'));
    }

    public function edit($id)
    {
        $item = Inventory::findOrFail($id);
        $categories = CategoriesRestaurant::where('status', 'active')->get();
        return view('Pages.Inventory.edit', compact('item', 'categories'));
    }

    public function show($id)
    {

        $item = Inventory::with(['category', 'item'])->findOrFail($id);
        return view('Pages.Inventory.show', compact('item'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'category_id'  => 'required|exists:categories_restaurants,id',
            'name'         => 'required|string|max:255',
            'sku'          => 'required|unique:inventories,sku',
            'quantity'     => 'required|numeric|min:0',
            'unit'         => 'required|string',
            'min_quantity' => 'required|numeric|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'sales_price'  => 'nullable|numeric|min:0',
            'supplier'     => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $category = CategoriesRestaurant::findOrFail($request->category_id);
            $itemType = $category->is_menu_category ? 'menu_item' : 'raw_material';

            $inventory = Inventory::create([
                'item_type'     => $itemType,
                'category_id'   => $request->category_id,
                'name'          => $request->name,
                'sku'           => $request->sku,
                'quantity'      => $request->quantity,
                'unit'          => $request->unit,
                'min_quantity'  => $request->min_quantity,
                'cost_per_unit' => $request->cost_per_unit,
                'supplier'      => $request->supplier,
            ]);

            if ($category->is_menu_category) {
                ItemsRestaurant::create([
                    'inventory_id' => $inventory->id,
                    'category_id'  => $request->category_id,
                    'item_name'    => $request->name,
                    'price'        => $request->sales_price ?? 0,
                    'status'       => 'available',
                    'quantity'     => $request->quantity,
                    'unit'         => $request->unit,
                    'min_quantity' => $request->min_quantity,
                ]);
            }

            return redirect()->route('Pages.inventory.index')->with('success', 'تم حفظ المادة  .');
        });
    }

    public function update(Request $request, $id)
    {

        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'category_id'  => 'required|exists:categories_restaurants,id',
            'name'         => 'required|string|max:255',
            'sku'          => 'required|string|unique:inventories,sku,' . $inventory->id,
            'quantity'     => 'required|numeric|min:0',
            'unit'         => 'required|string',
            'min_quantity' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request, $inventory) {
            if ($inventory->item) {
                $itemData = [
                    'item_name'    => $request->name,
                    'price'        => $request->sales_price,
                    'quantity'     => $request->quantity,
                    'unit'         => $request->unit,
                    'min_quantity' => $request->min_quantity,
                    'category_id'  => $request->category_id,
                ];
                $inventory->item->update($itemData);
            }

            return redirect()->route('Pages.inventory.index')->with('success', 'تم التحديث والمزامنة  .');
        });
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        if ($inventory->item) {
            $inventory->item->delete();
        }
        $inventory->delete();
        return redirect()->route('Pages.inventory.index')->with('success', 'تم حذف المادة وكل متعلقاتها من المنيو');
    }
}
