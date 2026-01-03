<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoriesRestaurantController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', CategoriesRestaurant::class);

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

    public function create()
    {
        $this->authorize('create', CategoriesRestaurant::class);
        $category = new CategoriesRestaurant();
        return view('Pages.Categories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255|unique:categories_restaurants,name',
            'status'           => 'required|in:active,inactive',
            'is_menu_category' => 'required|boolean',
            'description'      => 'nullable|string',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $category = new CategoriesRestaurant();
                $category->name = $request->name;
                $category->description = $request->description;
                $category->status = $request->status;
                $category->is_menu_category = $request->is_menu_category;
                $category->save();
                return redirect()->route('Pages.categories.index')->with('success', 'تم إضافة القسم بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ.');
        }
    }

    public function show($id)
    {
        $category = CategoriesRestaurant::with(['items.inventory'])->findOrFail($id);
        $this->authorize('view', $category);
        return view('Pages.Categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = CategoriesRestaurant::findOrFail($id);

        $this->authorize('update', $category);

        return view('Pages.Categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = CategoriesRestaurant::findOrFail($id);

        $this->authorize('update', $category);

        $request->validate([
            'name'             => 'required|string|max:255|unique:categories_restaurants,name,' . $id,
            'status'           => 'required|in:active,inactive',
            'is_menu_category' => 'required|boolean',
            'description'      => 'nullable|string',
        ]);

        try {
            return DB::transaction(function () use ($request, $category) {
                $category->name = $request->name;
                $category->description = $request->description;
                $category->status = $request->status;
                $category->is_menu_category = $request->is_menu_category;
                $category->save();
                return redirect()->route('Pages.categories.index')->with('success', 'تم التحديث بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث.');
        }
    }

    public function destroy($id)
    {
        $category = CategoriesRestaurant::findOrFail($id);

        $this->authorize('delete', $category);

        try {
            return DB::transaction(function () use ($category) {

                $category->delete();
                return redirect()->route('Pages.categories.index')->with('success', 'تم الحذف بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'فشل الحذف.');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', CategoriesRestaurant::class);

        $ids = $request->ids;
        if (!$ids || !is_array($ids)) return redirect()->back()->with('error', 'يرجى تحديد العناصر.');

        try {
            return DB::transaction(function () use ($ids) {
                $categories = CategoriesRestaurant::whereIn('id', $ids)->get();

                CategoriesRestaurant::whereIn('id', $ids)->delete();
                return redirect()->route('Pages.categories.index')->with('success', 'تم الحذف الجماعي بنجاح.');
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'فشل الحذف الجماعي.');
        }
    }
}
