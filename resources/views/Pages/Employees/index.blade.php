@extends('layouts.app')

@section('title', 'إدارة الموظفين')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center pt-4 pb-3">
            <h2 class="h3 text-light">
                <i class="fas fa-users-cog me-2 text-primary"></i> @lang('Employees List')</h2>

            {{-- تفعيل صلاحية الإضافة --}}
            @can('create', App\Models\Employee::class)
                <a href="{{ route('Pages.employee.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-user-plus me-2"></i> @lang('Add New Employee')</a>
            @endcan
        </div>

        <div class="mb-4">
            <x-flash_message />
        </div>

        <div class="card bg-dark shadow-lg border-0 mb-4">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover mb-0 align-middle">

                        <thead>
                            <tr class="text-secondary text-uppercase small border-bottom border-secondary">
                                <th class="ps-4">@lang('Name and Roles')</th> {{-- عدلنا العنوان هنا --}}
                                <th>@lang('Position')</th>
                                <th>@lang('Contact Information')</th>
                                <th>@lang('Salary')</th>
                                <th>@lang('Hire Date')</th>
                                <th>@lang('Status')</th>
                                <th class="text-center pe-4">@lang('Actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($employees as $employee)
                            @if ($employee->super_admin){{-- تجاهل عرض المدير العام --}}
                                @continue
                            @endif
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-white">{{ $employee->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary opacity-75">
                                            {{ $positions[$employee->position] ?? $employee->position }}
                                        </span>
                                    </td>
                                    <td>{{ $employee->phone }}</td>
                                    <td class="text-success fw-bold">{{ number_format($employee->salary, 2) }}</td>
                                    <td>{{ $employee->hire_date }}</td>
                                    <td>
                                        @if ($employee->status == 'active')
                                            <span
                                                class="badge bg-success-soft text-success border border-success px-3">نشط</span>
                                        @else
                                            <span class="badge bg-danger-soft text-danger border border-danger px-3">غير
                                                نشط</span>
                                        @endif
                                    </td>

                                    <td class="pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            @can('view', $employee)
                                                <a href="{{ route('Pages.employee.show', $employee->id) }}"
                                                    class="btn btn-sm btn-outline-light border-0" title="عرض التفاصيل">
                                                    <i class="fas fa-eye text-info"></i>
                                                </a>
                                            @endcan

                                            @can('update', $employee)
                                                <a href="{{ route('Pages.employee.edit', $employee->id) }}"
                                                    class="btn btn-sm btn-outline-light border-0" title="تعديل">
                                                    <i class="fas fa-edit text-warning"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $employee)
                                                <form method="POST"
                                                    action="{{ route('Pages.employee.destroy', $employee->id) }}"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف الموظف ({{ $employee->name }}) نهائياً؟');"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-light border-0"
                                                        title="حذف">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted italic">
                                        <i class="fas fa-user-slash d-block mb-3 fa-3x"></i>
                                        لا يوجد موظفين مسجلين حالياً في النظام.
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
