<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRestaurant;
use App\Models\ItemsRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemsRestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. جلب جميع الأقسام لعرضها في قائمة الفلترة
        $categories = CategoriesRestaurant::all();

        // 2. بناء استعلام الأطباق
        $query = ItemsRestaurant::with('category'); // جلب الصنف مع الفئة المرتبطة

        if ($request->filled('category_id')) { // تحقق من وجود قيمة في حقل الفئة
            $query->where('category_id', $request->category_id); // استخدم الفلترة حسب الفئة
        }

        if ($request->filled('status')) { // تحقق من وجود قيمة في الحقل
            $query->where('status', $request->status); // استخدم الفلترة حسب الحالة
        }

        $items = $query->get(); // تنفيذ الاستعلام وجلب النتائج

        return view('Pages.Items.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // جلب الأقسام المتوفرة فقط
        $categories = CategoriesRestaurant::where('status', 'active')->get();

        $item = new ItemsRestaurant(); // كائن فارغ للفورم
        return view('Pages.Items.create', compact('categories', 'item'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories_restaurants,id',
            'name' => 'required|string|max:255|unique:items_restaurants,item_name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,unavailable',
            'prepare_time' => 'nullable|integer|min:0',
        ]);
        $item = new ItemsRestaurant();
        $item->category_id = $request->category_id;
        $item->item_name = $request->name;
        $item->description = $request->description;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items_images', 'public');
            $item->image = $imagePath;
        }
        $item->price = $request->price;
        $item->status = $request->status;
        $item->prepare_time = $request->prepare_time;
        $item->save();
        return redirect()->route('Pages.Items.index')->with('success', 'تم إضافة الصنف بنجاح.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // جلب الصنف مع القسم الخاص به
        $item = ItemsRestaurant::with('category')->findOrFail($id);

        return view('Pages.Items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = ItemsRestaurant::findOrFail($id);
        $categories = CategoriesRestaurant::all();
        return view('Pages.Items.edit', compact('item', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    // لاحظ تغيير المسمى ليتوافق مع الـ Route أو استخدم المعرف مباشرة
    public function update(Request $request, $id)
    {
        // 1. جلب السجل الموجود فعلياً (لضمان عمل Update وليس Insert)
        $item = ItemsRestaurant::findOrFail($id);

        $request->validate([
            'category_id'  => 'required|exists:categories_restaurants,id',
            'name'         => 'required|string|max:255|unique:items_restaurants,item_name,' . $id,
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'        => 'required|numeric|min:0',
            'status'       => 'required|in:available,unavailable',
            'prepare_time' => 'nullable|integer|min:0',
        ]);

        $item->category_id  = $request->category_id;
        $item->item_name    = $request->name;
        $item->description  = $request->description;
        $item->price        = $request->price;
        $item->status       = $request->status;
        $item->prepare_time = $request->prepare_time;

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $item->image = $request->file('image')->store('items_images', 'public');
        }

        $item->save();

        return redirect()->route('Pages.Items.index')->with('success', 'تم تعديل الصنف بنجاح.');
    }

    public function destroy($id)
    {
        $item = ItemsRestaurant::findOrFail($id);
        // 2. حذف الصورة الفعلية من مجلد storage/app/public/items_images
        if ($item->image && Storage::disk('public')->exists($item->image)) { //تحقق من وجود صورة قبل محاولة حذفها
            Storage::disk('public')->delete($item->image); //حذف الصورة من التخزين
        }
        // حذف السجل من قاعدة البيانات
        $item->delete();
        return redirect()->route('Pages.Items.index')->with('success', 'تم حذف الطبق وصورته بنجاح');
    }
    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        if (!$ids) {
            return redirect()->back()->with('error', 'الرجاء تحديد عناصر أولاً');
        }

        // حذف الصور من السيرفر قبل حذف السجلات
        $items = ItemsRestaurant::whereIn('id', $ids)->get(); //جلب العناصر التي سيتم حذفها
        foreach ($items as $item) { //حذف الصورة الفعلية من مجلد storage/app/public/items_images
            if ($item->image) { //تحقق من وجود صورة قبل محاولة حذفها
                Storage::disk('public')->delete($item->image); //حذف الصورة من التخزين
            }
        }

        ItemsRestaurant::whereIn('id', $ids)->delete(); //حذف السجلات من قاعدة البيانات

        return redirect()->back()->with('success', 'تم حذف العناصر المختارة بنجاح');
    }
}
