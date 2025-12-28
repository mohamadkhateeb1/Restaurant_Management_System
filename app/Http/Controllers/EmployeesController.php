<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmoloyeeRequest;

class EmployeesController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Employee::class);
        $employees = Employee::with('roles')->get();
        return view('Pages.Employees.index', compact('employees'));
    }

    public function create()
    {
        return view('Pages.Employees.create', [
            'roles' => Role::all(),
            'employee' => new Employee()
        ]);
    }

    public function store(EmoloyeeRequest $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:employees,email',
            'phone'     => 'required|string|max:20',
            'position'  => 'required|string|max:100',
            'salary'    => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'status'    => 'required|in:active,inactive,on_leave',
            'notes'     => 'nullable|string',
            'password'  => 'required|string|min:8',
            'roles'     => 'required|array',
        ]);

        $employee = Employee::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'position'  => $request->position,
            'salary'    => $request->salary,
            'hire_date' => $request->hire_date,
            'status'    => $request->status,
            'notes'     => $request->notes,
            'password'  => Hash::make($request->password),
        ]);

        $employee->roles()->attach($request->roles);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
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

        $request->validate([
            'name'      => 'string|max:255',
            'email'     => 'email|unique:employees,email,' . $id,
            'phone'     => 'string|max:20',
            'position'  => 'string|max:100',
            'salary'    => 'numeric|min:0',
            'hire_date' => 'date',
            'status'    => 'in:active,inactive,on_leave',
            'notes'     => 'nullable|string',
            'password'  => 'nullable|string|min:8',
            'roles'     => 'array',
        ]);

        $employee->update($request->only([
            'name',
            'email',
            'phone',
            'position',
            'salary',
            'hire_date',
            'status',
            'notes'
        ]));

        if ($request->filled('password')) {
            $employee->update(['password' => Hash::make($request->password)]);
        }

        $employee->roles()->sync($request->roles);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee updated successfully.');
    }

    public function show($id)
    {
        $employee = Employee::with('roles')->findOrFail($id);

        return view('Pages.Employees.show', compact('employee'));
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();
        return redirect()->route('Pages.employee.index')->with('success', 'Employee deleted successfully.');
    }
}
