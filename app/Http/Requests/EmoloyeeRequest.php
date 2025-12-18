<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmoloyeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }


    public static function rules($id = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($id)],
            'phone'     => ['required', 'string', 'max:20', Rule::unique('employees', 'phone')->ignore($id)],
            'position'  => 'required|string|max:100',
            'salary'    => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'notes'     => 'nullable|string',
            'status'    => 'required|in:active,inactive',
            'password'  => $id ? 'nullable|string|min:8' : 'required|string|min:8',
        ];
    }
    public function messages(): array
    {
        return [
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل من قبل موظف آخر.',
            'phone.unique' => 'رقم الهاتف هذا مستخدم بالفعل من قبل موظف آخر.',
            'password.required' => 'كلمة المرور مطلوبة عند إنشاء موظف جديد.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 8 أحرف.',
            'status.in' => 'الحالة يجب أن تكون إما "active" أو "inactive".',
            'hire_date.date' => 'تاريخ التوظيف يجب أن يكون تاريخًا صالحًا.',
            'salary.numeric' => 'الراتب يجب أن يكون رقمًا صالحًا.',
            'salary.min' => 'الراتب يجب أن يكون قيمة موجبة.',
            'name.required' => 'اسم الموظف مطلوب.',
            'position.required' => 'المسمى الوظيفي مطلوب.',
            'position.max' => 'المسمى الوظيفي يجب ألا يتجاوز 100 حرف.',
        ];
    }
}
