@extends('layouts.app')

@section('title', 'إضافة موظف جديد')

@section('content')
    <div class="container-fluid py-4">

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                {{-- رأس الصفحة --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-light">إضافة موظف جديد</h2>
                    <a href="{{ route('Pages.employee.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                        <i class="fas fa-arrow-right me-2"></i> العودة للقائمة
                    </a>
                </div>

                {{-- بطاقة النموذج --}}
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="fas fa-user-plus me-2"></i> بيانات الموظف الجديدة
                    </div>
                    <div class="card-body bg-dark text-white">
                        <form method="POST" action="{{ route('Pages.employee.store') }}">
                            @csrf

                            {{-- تضمين النموذج المشترك --}}
                            @include('Pages.Employees._form')

                            <div class="d-grid mt-4 pt-3 border-top border-secondary">
                                <button type="submit" class="btn btn-success btn-lg fw-bold">
                                    <i class="fas fa-save me-2"></i> حفظ الموظف وإضافته للنظام
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection