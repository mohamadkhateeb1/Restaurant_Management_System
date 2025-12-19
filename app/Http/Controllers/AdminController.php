<?php

namespace App\Http\Controllers;

use App\Concems\HasRoles;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('roles')->get();
        return view('Pages.Admin.index', ['admins' => $admins]);
    }


    public function create()
    {
        return view('Pages.Admin.create', [
            'roles' => Role::all(),
            'admin' => new Admin()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'roles'    => 'required|array',
        ]);

        // إنشاء الأدمن بالحقول المسموح بها
        $admin = Admin::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        // ربط الأدمن بالرولز المحددة
        $admin->roles()->attach($data['roles']); //هذا يعني أنه سيتم ربط الأدمن بالرولز التي تم اختيارها في الفورم
        //$admin->roles()->attach(1,2,3)
        return redirect()->route('Pages.admin.index')->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
 public function show(Admin $admin)
{
    // جلب الأدوار مع الصلاحيات الخاصة بكل دور
    $admin->load('roles.abilities');

    return view('Pages.Admin.show', compact('admin'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('Pages.Admin.edit', [
            'admin' => $admin,
            'roles' => Role::all(),
            'adminRoles' => $admin->roles->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([// هون بنعمل فالدات عشان نتأكد من صحة البيانات المدخلة
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email'],
            'password' => 'nullable|string|min:8',
            'roles'    => 'required|array',
        ]);

        $update = [
            'name'  => $data['name'],// هون بنحدث الاسم
            'email' => $data['email'],// هون بنحدث الاسم والايميل
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);// هون بنحدث الباسورد اذا كان موجود
        }

        $admin->update($update);// هون بنحدث بيانات الأدمن
        $admin->roles()->sync($data['roles']);// هون بنحدث الرولز تبع الأدمن
        //admin role_(1,2)
        //  $admin->roles()->sync(3)
        // sync : طابق بالضبط على الرولز اضف الجديد واحذف الزائد الغير محدد
        // attach :اضف فقط لا تمسح القديمين
        return redirect()->route('Pages.admin.index')->with('success', 'Admin updated successfully.');
        //هي يعني يرجعني على صفحة الأدمن مع رسالة نجاح
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin = Admin::findOrFail($admin->id);
        $admin->delete();
        return redirect()->route('Pages.admin.index')->with('success', 'Admin deleted successfully.');
    }
}
