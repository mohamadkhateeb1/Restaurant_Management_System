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

        $data = $request->validated(); // يفضل استخدام validated() الجاهزة من الـ Request class

        $employee = Employee::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'position'  => $data['position'],
            'salary'    => $data['salary'],
            'hire_date' => $data['hire_date'],
            'status'    => $data['status'],
            'notes'     => $data['notes'] ?? null,
            'password'  => Hash::make($data['password']),
        ]);

        $employee->roles()->attach($request->roles);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        // $this->authorize('update', $employee);


        return view('Pages.Employees.edit', [
            'employee' => $employee,
            'roles' => Role::all(),
            'employeeRoles' => $employee->roles->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        // $this->authorize('update', $employee);
        

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:employees,email,'.$id,
            'phone'     => 'required|string|max:20',
            'position'  => 'required|string|max:100',
            'salary'    => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'status'    => 'required|in:active,inactive,on_leave',
            'notes'     => 'nullable|string',
            'password'  => 'nullable|string|min:8|confirmed',
            'roles'     => 'required|array',
        ]);

        $employee->fill($data);

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        $employee->save();
        $employee->roles()->sync($request->roles);

        return redirect()->route('Pages.employee.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        // $this->authorize('delete', $employee);
        
        $employee->delete();
        return redirect()->route('Pages.employee.index')->with('success', 'Employee deleted successfully.');
    }
}