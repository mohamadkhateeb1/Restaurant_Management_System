@extends('layouts.app')
@section('title', 'ملف الموظف: ' . $employee->name)
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 text-light">
                <i class="fas fa-id-badge text-info me-2"></i> ملف الموظف: <span
                    class="text-info">{{ $employee->name }}</span>
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('Pages.employee.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="fas fa-arrow-right me-2"></i>@lang('Back to List')
                </a>
                @can('update', App\Models\Employee::class)
                    <a href="{{ route('Pages.employee.edit', $employee->id) }}"
                        class="btn btn-warning btn-sm px-3 shadow-sm text-dark fw-bold">
                        <i class="fas fa-edit me-2"></i> تعديل البيانات
                    </a>
                @endcan
            </div>
        </div>
        <div class="row g-4">
            <div class="col-xl-4 col-lg-5">
                <div class="card bg-dark shadow-lg border-0 h-100 overflow-hidden" style="border-radius: 15px;">
                    <div class="card-header bg-info py-3 text-center">
                        <div class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-2 shadow-sm"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-3x text-info"></i>
                        </div>
                        <h4 class="mb-0 text-white fw-bold">{{ $employee->name }}</h4>
                        <small class="text-white-50">{{ $employee->position }}</small>
                    </div>
                    <div class="card-body p-4 text-white">
                        <h6 class="text-info border-bottom border-secondary pb-2 mb-3 small text-uppercase fw-bold">بيانات
                            الاتصال</h6>
                        <div class="mb-3 d-flex align-items-center">
                            <i class="fas fa-envelope text-muted me-3 w-20"></i>
                            <div>
                                <small class="text-muted d-block">البريد الإلكتروني</small>
                                <span class="text-warning">{{ $employee->email }}</span>
                            </div>
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <i class="fas fa-phone text-muted me-3 w-20"></i>
                            <div>
                                <small class="text-muted d-block">رقم الهاتف</small>
                                <span>{{ $employee->phone }}</span>
                            </div>
                        </div>
                        <div class="mb-4 d-flex align-items-center">
                            <i class="fas fa-toggle-on text-muted me-3 w-20"></i>
                            <div>
                                <small class="text-muted d-block">حالة الحساب</small>
                                @if ($employee->status == 'active')
                                    <span
                                        class="badge bg-success-soft text-success border border-success px-3 py-1 mt-1">نشط</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger border border-danger px-3 py-1 mt-1">غير
                                        نشط</span>
                                @endif
                            </div>
                        </div>
                        <h6 class="text-info border-bottom border-secondary pb-2 mb-3 small text-uppercase fw-bold">الأدوار
                            والصلاحيات</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse($employee->roles as $role)
                                <span
                                    class="badge bg-primary-soft text-primary border border-primary px-3 py-2 rounded-pill">
                                    <i class="fas fa-shield-alt me-1"></i> {{ $role->name }}
                                </span>
                            @empty
                                <small class="text-muted italic">لا توجد أدوار محددة</small>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="card bg-dark border-0 shadow-sm p-3 h-100"
                            style="border-right: 4px solid #0d6efd !important;">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="fas fa-briefcase fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">المسمى الوظيفي</small>
                                    <h4 class="mb-0 text-white fw-bold">{{ $employee->position }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card bg-dark border-0 shadow-sm p-3 h-100"
                            style="border-right: 4px solid #198754 !important;">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">الراتب الشهري</small>
                                    <h4 class="mb-0 text-success fw-bold">{{ number_format($employee->salary, 2) }}
                                        <small>SAR</small>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card bg-dark border-0 shadow-sm p-3 h-100"
                            style="border-right: 4px solid #0dcaf0 !important;">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="fas fa-calendar-check fa-2x text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">تاريخ التوظيف</small>
                                    <h4 class="mb-0 text-white fw-bold">{{ $employee->hire_date }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card bg-dark border-0 shadow-sm p-3 h-100"
                            style="border-right: 4px solid #6c757d !important;">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded-3 me-3">
                                    <i class="fas fa-user-clock fa-2x text-secondary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">مدة الخدمة</small>
                                    <h4 class="mb-0 text-white fw-bold">{{ now()->diffInDays($employee->hire_date) }} يوم
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card bg-dark border-0 shadow-lg p-4" style="border-radius: 15px;">
                            <h5 class="text-info border-bottom border-secondary pb-2 mb-3">
                                <i class="fas fa-sticky-note me-2"></i> ملاحظات الإدارة والموارد البشرية
                            </h5>
                            @if ($employee->notes)
                                <p
                                    class="text-white-50 lh-lg bg-secondary bg-opacity-10 p-3 rounded border-start border-info border-3">
                                    {{ $employee->notes }}
                                </p>
                            @else
                                <div class="text-center py-4 text-muted italic">
                                    <i class="fas fa-comment-slash d-block mb-2 fa-2x"></i>
                                    لا توجد ملاحظات مسجلة لهذا الموظف
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-info-soft {
            background-color: rgba(13, 202, 240, 0.1);
        }

        .w-20 {
            width: 25px;
            text-align: center;
        }

        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endpush
