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
        $this->authorize('create', Employee::class);
        
        return view('Pages.Employees.create', [
            'roles' => Role::all(),
            'employee' => new Employee()
        ]);
    }

    public function store(EmoloyeeRequest $request)
    {
        // $this->authorize('create', Employee::class);
        $employee = new Employee();
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
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->status = $request->status;
        $employee->notes = $request->notes;
        $employee->password = Hash::make($request->password);
        $employee->save();
        $employee->roles()->attach($request->roles);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $this->authorize('update', $employee);


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
            'email'     => 'email|unique:employees,email,'.$id,
            'phone'     => 'string|max:20',
            'position'  => 'string|max:100',
            'salary'    => 'numeric|min:0',
            'hire_date' => 'date',
            'status'    => 'in:active,inactive,on_leave',
            'notes'     => 'nullable|string',
            'password'  => 'nullable|string|min:8',
            'roles'     => 'array',
        ]);
        $employee->name = $request->name ?? $employee->name;
        $employee->email = $request->email ?? $employee->email;
        $employee->phone = $request->phone ?? $employee->phone;
        $employee->position = $request->position ?? $employee->position;
        $employee->salary = $request->salary ?? $employee->salary;
        $employee->hire_date = $request->hire_date ?? $employee->hire_date;
        $employee->status = $request->status ?? $employee->status;
        $employee->notes = $request->notes ?? $employee->notes;

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        $employee->save();
        $employee->roles()->sync($request->roles);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee updated successfully.');
    }
    public function show($id)
    {
        $employee = Employee::with('roles')->findOrFail($id);
        $this->authorize('view', $employee);

        return view('Pages.Employees.show', compact('employee'));
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        // $this->authorize('delete', $employee);
        
        $employee->delete();
        return redirect()->route('Pages.employee.index')->with('success', 'Employee deleted successfully.');
    }
}