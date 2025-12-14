<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use App\Models\UserRestaurant;
use App\Http\Requests\EmoloyeeRequest;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employees::all();
        return view('Admin.Employees.index', ['employees'=>$employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // حفظ موظف جديد
        $employee= new Employees();
        $request->validate(EmoloyeeRequest::rules());// (clean code) نتحقق من صحة البيانات عن طريق كلاس نقوم بإنشائه 
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->notes = $request->notes;
        $employee->status = $request->status;
        $employee->save();
        return redirect()->route('Admin.employee.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employees::findOrFail($id);
        return view('Admin.Employees.show', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function edit($id)
        {
            $employees = Employees::findOrFail($id);
            return view('Admin.Employees.edit', ['employee' => $employees]);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employees::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
       
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->notes = $request->notes;
        $employee->status = $request->status;
        $employee->save();
        return redirect()->route('Admin.employee.index')->with('warning', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employees = Employees::findOrFail($id);
        $employees->delete();
        return redirect()->route('Admin.employee.index')->with('danger', 'Employee deleted successfully.');
    }
}
