@extends('layouts.app')
@section('title', 'تعديل موظف: ' . $employee->name)
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-light">
                        <i class="fas fa-user-edit text-warning me-2"></i> تعديل بيانات الموظف:
                        <span class="text-warning fw-bold">{{ $employee->name }}</span>
                    </h2>
                    <a href="{{ route('Pages.employee.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="fas fa-arrow-right me-2"></i> العودة للقائمة
                    </a>
                </div>
                <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 15px;">
                    <div class="card-header py-3" style="background: linear-gradient(45deg, #ffc107, #ff9800);">
                        <h5 class="card-title mb-0 text-dark fw-bold">
                            <i class="fas fa-save me-2"></i> نموذج تحديث البيانات
                        </h5>
                    </div>
                    <div class="card-body bg-dark p-4">
                        <form method="POST" action="{{ route('Pages.employee.update', $employee->id) }}">
                            @csrf
                            @method('PUT')
                            @include('Pages.Employees._form')
                            <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top border-secondary">
                                <a href="{{ route('Pages.employee.index') }}" class="btn btn-outline-secondary px-4">
                                    إلغاء
                                </a>
                                <button type="submit" class="btn btn-warning btn-lg px-5 fw-bold shadow">
                                    <i class="fas fa-sync-alt me-2"></i> حفظ التعديلات الجديدة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .card {
            border: 1px solid rgba(255, 193, 7, 0.2) !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ffc107 !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15) !important;
        }

        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
    </style>
@endpush
