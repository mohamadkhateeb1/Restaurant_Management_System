<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmoloyeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public static function rules($id = null): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('employees', 'email')->ignore($id)],
            'phone'     => ['required', 'string', 'max:20', Rule::unique('employees', 'phone')->ignore($id)],
            'position'  => 'required|string|max:100',
            'salary'    => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'notes'     => 'nullable|string',
            'status'    => 'required|in:active,inactive',
            'password'  => $id ? 'nullable|string|min:8' : 'required|string|min:8',
            'roles'     => 'required|array',
            'roles.*'   => 'exists:roles,id',
        ];
    }
}
