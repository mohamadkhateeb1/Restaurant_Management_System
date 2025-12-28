@extends('layouts.app')
@section('title', 'إضافة موظف جديد')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-light">
                        <i class="fas fa-user-plus text-primary me-2"></i> @lang('Add New Employee')
                    </h2>
                    <a href="{{ route('Pages.employee.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="fas fa-arrow-right me-2"></i> @lang('Back to List')
                    </a>
                </div>
                <div class="card shadow-lg border-0 overflow-hidden">
                    <div class="card-header bg-primary py-3">
                        <h5 class="card-title mb-0 text-white fw-bold">
                            <i class="fas fa-id-card me-2"></i> @lang('Employee Details and Permissions')
                        </h5>
                    </div>
                    <div class="card-body bg-dark text-white p-4">
                        <form method="POST" action="{{ route('Pages.employee.store') }}">
                            @csrf
                            @include('Pages.Employees._form')
                            <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top border-secondary">
                                <button type="reset" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-undo me-2"></i> @lang('Reset')
                                </button>
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                                    <i class="fas fa-save me-2"></i> @lang('Save Employee')
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
        .form-control:focus,
        .form-select:focus {
            background-color: #2b3035 !important;
            color: #fff !important;
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .card {
            border-radius: 15px;
        }

        .btn-lg {
            border-radius: 10px;
        }
    </style>
@endpush
