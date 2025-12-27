<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoriesRestaurantController extends Controller
{
    /**
     * عرض جميع الأقسام مع تفعيل نظام الفلترة المتقدم.
     */
    public function index(Request $request)
    {
        $categories = CategoriesRestaurant::query()
            ->when($request->name, function ($q) use ($request) {
                return $q->where('name', 'LIKE', "%{$request->name}%");
            })
            ->when($request->status, function ($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->has('type') && $request->type !== '', function ($q) use ($request) {
                return $q->where('is_menu_category', $request->type);
            })
            ->orderBy('status', 'asc')
            ->orderBy('is_menu_category', 'desc')
            ->get();

        return view('Pages.Categories.index', compact('categories'));
    }

    /**
     * واجهة إضافة قسم جديد.
     */
    public function create()
    {
        $category = new CategoriesRestaurant(); 
        return view('Pages.Categories.create', compact('category'));
    }

    /**
     * حفظ القسم الجديد.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255|unique:categories_restaurants,name',
            'status'           => 'required|in:active,inactive',
            'is_menu_category' => 'required|boolean', 
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $category = new CategoriesRestaurant();
                $category->name = $request->name;
                $category->description = $request->description;
                $category->status = $request->status;
                $category->is_menu_category = $request->is_menu_category;

                if ($request->hasFile('image')) {
                    $category->image = $request->file('image')->store('categories', 'public');
                }

                $category->save();

                return redirect()->route('Pages.categories.index')->with('success', 'تم إضافة القسم الجديد بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ، يرجى المحاولة لاحقاً.');
        }
    }

    /**
     * عرض تفاصيل القسم.
     */
    public function show($id)
    {
        $category = CategoriesRestaurant::with(['items.inventory'])->findOrFail($id);
        return view('Pages.Categories.show', compact('category'));
    }

    /**
     * واجهة تعديل القسم.
     */
    public function edit($id)
    {
        $category = CategoriesRestaurant::findOrFail($id);
        return view('Pages.Categories.edit', compact('category'));
    }

    /**
     * تحديث بيانات القسم.
     */
    public function update(Request $request, $id)
    {
        $category = CategoriesRestaurant::findOrFail($id);

        $request->validate([
            'name'             => 'required|string|max:255|unique:categories_restaurants,name,' . $id,
            'status'           => 'required|in:active,inactive',
            'is_menu_category' => 'required|boolean',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            return DB::transaction(function () use ($request, $category) {
                $category->name = $request->name;
                $category->description = $request->description;
                $category->status = $request->status;
                $category->is_menu_category = $request->is_menu_category;

                if ($request->hasFile('image')) {
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                    $category->image = $request->file('image')->store('categories', 'public');
                }

                $category->save();
                
                return redirect()->route('Pages.categories.index')->with('success', 'تم تحديث بيانات القسم بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث.');
        }
    }

    /**
     * حذف قسم واحد (تم التعديل لضمان حذف الصورة والسجل معاً).
     */
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $category = CategoriesRestaurant::findOrFail($id);

                // حذف الصورة من القرص الصلب أولاً
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                // حذف السجل من قاعدة البيانات
                $category->delete();

                return redirect()->route('Pages.categories.index')->with('success', 'تم حذف القسم وجميع صوره بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'لا يمكن حذف القسم، قد يكون مرتبطاً بمنتجات أو طلبات نشطة.');
        }
    }

    /**
     * الحذف الجماعي للأقسام المحددة (تم التعديل لضمان حذف الصور دفعة واحدة).
     */
    public function bulkDestroy(Request $request)
    {
        // التأكد من أن IDs وصلت كمصفوفة
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return redirect()->back()->with('error', 'يرجى تحديد العناصر المطلوب حذفها أولاً.');
        }

        try {
            return DB::transaction(function () use ($ids) {
                $categories = CategoriesRestaurant::whereIn('id', $ids)->get();
                
                // الدوران على الأقسام لحذف صورها من التخزين
                foreach ($categories as $category) {
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                }

                // حذف جميع السجلات دفعة واحدة بعد حذف الصور
                CategoriesRestaurant::whereIn('id', $ids)->delete();
                
                return redirect()->route('Pages.categories.index')->with('success', 'تم مسح كافة الأقسام والصور المحددة بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'فشل الحذف الجماعي، بعض الأقسام مرتبطة ببيانات أخرى لا يمكن حذفها.');
        }
    }
}