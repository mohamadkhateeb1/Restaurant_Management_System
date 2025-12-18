<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Requests\EmoloyeeRequest; // تأكد من تصحيح الاسم إذا كان هناك خطأ إملائي في الملف نفسه

class EmployeesController extends Controller
{
    /**
     * عرض قائمة الموظفين
     */
    public function index()
    {
        $employees = Employee::all(); // جلب الأحدث أولاً
        return view('Pages.Employees.index', ['employees' => $employees]);
    }

    /**
     * عرض صفحة إنشاء موظف جديد
     */
    public function create()
    {
        return view('Pages.Employees.create');
    }

    /**
     * تخزين موظف جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // التحقق من البيانات باستخدام الـ Request Class الخاص بك
        // تأكد أن EmoloyeeRequest يحتوي على 'password' => 'required|min:8'
        $validatedData = $request->validate(EmoloyeeRequest::rules());

        // تشفير كلمة المرور قبل الحفظ
        $validatedData['password'] = Hash::make($request->password);

        // استخدام Mass Assignment للحفظ السريع (تأكد من وجود الحقول في $fillable داخل الموديل)
        Employee::create($validatedData);

        return redirect()->route('Pages.employee.index')
            ->with('success', 'تم إضافة الموظف بنجاح.');
    }

    /**
     * عرض بيانات موظف محدد
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('Pages.Employees.show', compact('employee'));
    }

    /**
     * عرض صفحة تعديل موظف
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('Pages.Employees.edit', compact('employee'));
    }

    /**
     * تحديث بيانات الموظف
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // قواعد التحقق المخصصة للتحديث لضمان عدم تكرار الإيميل والهاتف مع الآخرين
        $request->validate(
            EmoloyeeRequest::rules($id)
        );

        // تحديث البيانات الأساسية
        $data = $request->except('password');

        // تحديث كلمة المرور فقط إذا تم إدخالها
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('Pages.employee.index')
            ->with('warning', 'تم تحديث بيانات الموظف بنجاح.');
    }

    /**
     * حذف موظف
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('Pages.employee.index')
            ->with('danger', 'تم حذف الموظف من النظام.');
    }
}
