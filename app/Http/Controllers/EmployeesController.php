<?php

namespace App\Http\Controllers;

use App\Concerns\HasRoles;// استدعاء التريت
use App\Models\Employee;// استدعاء الموديل
use App\Models\Role;// استدعاء موديل الدور
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmoloyeeRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class EmployeesController extends Controller
{
    use HasRoles;
    public function index()
    {
        Gate::authorize('employee.view');
        $employees = Employee::with('roles')->get();
        return view('Pages.Employees.index', ['employees' => $employees]);
    }

    public function create()
    {
        // Gate::authorize('employee.create', Employee::class);
        return view('Pages.Employees.create', [
            'roles' => Role::all(),
            'employee' => new Employee()
        ]);
    }

    public function store(EmoloyeeRequest $request)
    {
        $data = $request->validate(EmoloyeeRequest::rules() + [
            'roles' => 'required|array',
        ]);

        $employee = Employee::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'position'  => $data['position'],
            'salary'    => $data['salary'],
            'hire_date' => $data['hire_date'],
            'status'    => $data['status'], // أضفنا الستاتوس لأنها موجودة في الـ Request
            'notes'     => $data['notes'] ?? null,
            'password'  => Hash::make($data['password']),
        ]);

        // الربط بنفس طريقة الأدمن
        $employee->roles()->attach($data['roles']);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee created successfully.');
    }

    public function show($id)
    {
        // Gate::authorize('employee.show', Employee::class);
        $employee = Employee::with('roles')->findOrFail($id);
        return view('Pages.Employees.show', ['employee' => $employee]);
    }

    public function edit($id)
    {
        // Gate::authorize('employee.edit', Employee::class);
        $employee = Employee::findOrFail($id);
        return view('Pages.Employees.edit', [
            'employee' => $employee,
            'roles' => Role::all(),
            'employeeRoles' => $employee->roles->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string|max:20',
            'position'  => 'required|string|max:100',
            'salary'    => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'status'    => 'required|in:active,inactive,on_leave',
            'notes'     => 'nullable|string',
            'password'  => 'nullable|string|min:8|confirmed',
            'roles'     => 'required|array',
        ]);

        $update = [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'position'  => $data['position'],
            'salary'    => $data['salary'],
            'hire_date' => $data['hire_date'],
            'status'    => $data['status'],
            'notes'     => $data['notes'] ?? null,
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $employee->update($update);

        // التحديث بنفس طريقة الأدمن
        $employee->roles()->sync($data['roles']);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        // Gate::authorize('employee.delete', Employee::class);
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('Pages.employee.index')->with('success', 'Employee deleted successfully.');
    }
}
