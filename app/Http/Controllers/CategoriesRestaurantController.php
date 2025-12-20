<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRestaurant;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use Illuminate\Support\Facades\Storage;
class CategoriesRestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoriesRestaurant::all();
        return view('Pages.Categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoriesRestaurant::all();

        return view('Pages.Categories.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(CategoriesRequest::rules());
        $category = new CategoriesRestaurant();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->price = $request->price;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }
        $category->save();
        return redirect()->route('Pages.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = CategoriesRestaurant::findOrFail($id);
        return view('Pages.Categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = CategoriesRestaurant::findOrFail($id);
        return view('Pages.Categories.edit', ['category' => $category]);
    }
    public function bulkDestroy(Request $request)
{
    $ids = $request->ids;
    if (!$ids) {
        return redirect()->back()->with('error', 'الرجاء تحديد عناصر أولاً');
    }

    // حذف الصور من السيرفر قبل حذف السجلات
    $items = CategoriesRestaurant::whereIn('id', $ids)->get();
    foreach ($items as $item) {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
    }

    CategoriesRestaurant::whereIn('id', $ids)->delete();

    return redirect()->back()->with('success', 'تم حذف العناصر المختارة بنجاح');
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0',
        ]);
        $category = CategoriesRestaurant::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->price = $request->price;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }
        $category->save();
        return redirect()->route('Pages.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category=CategoriesRestaurant::findOrFail($id);
        $category->delete();
        return redirect()->route('Pages.categories.index')->with('success', 'Category deleted successfully.');
    }
}
