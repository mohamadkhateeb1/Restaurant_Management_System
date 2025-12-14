@extends('layouts.app')

@section('title', 'إدارة الموظفين')

@section('content')

    <div class="container-fluid">

        {{-- رأس الصفحة وزر الإضافة --}}
        <div class="d-flex justify-content-between align-items-center pt-4 pb-3">
            <h2 class="h3 text-light">
                قائمة الموظفين
            </h2>

            {{-- زر إضافة موظف جديد --}}
            <a href="{{ route('Admin.employee.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i>
                إضافة موظف جديد
            </a>
        </div>
        <div class="mb-4">
            <x-flash_message />
        </div>

        {{-- بطاقة الجدول الرئيسية --}}
        <div class="card bg-dark shadow-lg border-0 mb-4">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover mb-0">

                        <thead>
                            <tr class="text-secondary text-uppercase small">
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>وظيفة الموظف</th>
                                <th>راتب الموظف</th>
                                <th>تاريخ التوظيف</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse (isset($employees) ? $employees : [] as $employee)
                                <tr>
                                    {{-- خلايا البيانات --}}
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->salary }}</td>
                                    <td>{{ $employee->hire_date }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">

                                            <a href="{{ route('Admin.employee.edit', $employee->id) }}"
                                                class="text-info mx-2" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form method="POST"
                                                action="{{ route('Admin.employee.destroy', $employee->id) }}"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn btn-link text-danger p-0 border-0 bg-transparent"
                                                    title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('Admin.employee.show', $employee->id) }}"
                                                class="text-info mx-2" title="عرض">
                                                <i class="fas fa-eye"></i>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        لا يوجد موظفين مسجلين حالياً.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
