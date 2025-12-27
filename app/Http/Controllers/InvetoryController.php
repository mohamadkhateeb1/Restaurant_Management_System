<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\CategoriesRestaurant;
use App\Models\ItemsRestaurant; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class InvetoryController extends Controller
{
    /**
     * عرض قائمة المخزون مع الفلترة المتقدمة.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Inventory::class);
        $categories = CategoriesRestaurant::all();
        $query = Inventory::with(['category', 'item']); 

        // 1. فلترة حسب نوع المادة (raw_material أو menu_item)
        if ($request->filled('item_type')) {
            $query->where('item_type', $request->item_type);
        }

        // 2. فلترة حسب القسم
        if ($request->filled('category_id')) { 
            $query->where('category_id', $request->category_id);
        }

        // 3. فلترة حسب حالة المخزون (نواقص)
        if ($request->status == 'low_stock') {
            $query->whereRaw('quantity <= min_quantity');
        }

        // 4. فلترة البحث بالاسم أو الـ SKU
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('sku', 'LIKE', "%{$request->search}%");
            });
        }

        $items = $query->latest()->get();
        return view('Pages.Inventory.index', compact('items', 'categories'));
    }

    public function create()
    {
        // نرسل فقط الأقسام النشطة ليتم الاختيار منها
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

    /**
     * الحفظ الذكي: القسم هو من يحدد نوع المادة آلياً.
     */
  public function store(Request $request)
{
    $request->validate([
        'category_id'  => 'required|exists:categories_restaurants,id',
        'name'         => 'required|string|max:255',
        'sku'          => 'required|unique:inventories,sku',
        'quantity'     => 'required|numeric|min:0',
        'unit'         => 'required|string',
        'min_quantity' => 'required|numeric|min:0',
        'cost_per_unit'=> 'nullable|numeric|min:0',
        'sales_price'  => 'nullable|numeric|min:0',
        'supplier'     => 'nullable|string',
        'image'        => 'nullable|image|max:2048', // التحقق من أن الملف صورة
    ]);

    return DB::transaction(function () use ($request) {
        $category = CategoriesRestaurant::findOrFail($request->category_id);
        $itemType = $category->is_menu_category ? 'menu_item' : 'raw_material';

        // 1. معالجة رفع الصورة وتخزين المسار
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items_images', 'public');
        }

        // 2. إنشاء سجل المخزن
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

        // 3. إذا كان القسم "بيعي"، ننشئ نسخة المنيو ونربط الصورة بها
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
                'image'        => $imagePath, // حفظ مسار الملف المرفوع
            ]);
        }

        return redirect()->route('Pages.inventory.index')->with('success', 'تم حفظ المادة ورفع الصورة بنجاح.');
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
        'image'        => 'nullable|image|max:2048',
    ]);

    return DB::transaction(function () use ($request, $inventory) {
        // تحديث بيانات المخزن
        $inventory->update($request->except('image'));

        if ($inventory->item) {
            $itemData = [
                'item_name'    => $request->name,
                'price'        => $request->sales_price,
                'quantity'     => $request->quantity,
                'unit'         => $request->unit,
                'min_quantity' => $request->min_quantity,
                'category_id'  => $request->category_id,
            ];

            // معالجة تحديث الصورة: مسح القديمة ورفع الجديدة
            if ($request->hasFile('image')) {
                if ($inventory->item->image) {
                    Storage::disk('public')->delete($inventory->item->image);
                }
                $itemData['image'] = $request->file('image')->store('items_images', 'public');
            }

            $inventory->item->update($itemData);
        }

        return redirect()->route('Pages.inventory.index')->with('success', 'تم التحديث ومزامنة الصورة بنجاح.');
    });
}

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        
        // الحذف يتم للمخزن، وسيقوم الـ Database Cascade بحذف الـ Item المرتبط آلياً
        // لكن زيادة تأكيد برمجياً:
        if ($inventory->item) {
            $inventory->item->delete();
        }
        
        $inventory->delete();
        return redirect()->route('Pages.inventory.index')->with('success', 'تم حذف المادة وكل متعلقاتها من المنيو');
    }
}