@extends('layouts.app')

@section('title', 'تعديل موظف: ' . $employee->name) {{-- عرض اسم الموظف في العنوان --}}

@section('content')

    <div class="container-fluid py-4">

        <x-flash_message />

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                {{-- رأس الصفحة وزر العودة --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-light">
                        تعديل بيانات الموظف: <span class="text-warning">{{ $employee->name }}</span>
                    </h2>
                    {{-- زر العودة لقائمة الموظفين --}}
                    <a href="{{ route('Admin.employee.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                </div>

                {{-- البطاقة الرئيسية للنموذج --}}
                <div class="card shadow-lg">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">تعديل بيانات الموظف الأساسية</h5>
                    </div>
                    <div class="card-body">

                        {{-- نموذج الإرسال --}}
                        <form method="POST" action="{{ route('Admin.employee.update', $employee->id) }}">
                            @csrf
                            @method('PUT')

                            @include('Admin.Employees._form', ['employee' => $employee])

                            {{-- زر الإرسال في أسفل النموذج --}}
                            <div class="d-grid mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    حفظ التعديلات
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
