@extends('layouts.app')

@section('title', 'تعديل موظف: ' . $employee->name)

@section('content')
    <div class="container-fluid py-4">

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                {{-- رأس الصفحة --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-light">
                        تعديل بيانات الموظف: <span class="text-warning">{{ $employee->name }}</span>
                    </h2>
                    <a href="{{ route('Pages.employee.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                        <i class="fas fa-arrow-right me-2"></i> العودة للقائمة
                    </a>
                </div>

    

                {{-- بطاقة النموذج --}}
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-dark fw-bold">
                        <i class="fas fa-user-edit me-2"></i> تعديل بيانات الموظف الأساسية
                    </div>
                    <div class="card-body bg-dark">
                        <form method="POST" action="{{ route('Pages.employee.update', $employee->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- تضمين النموذج المشترك --}}
                            @include('Pages.Employees._form', ['employee' => $employee])

                            <div class="d-grid mt-4 pt-3 border-top border-secondary">
                                <button type="submit" class="btn btn-warning btn-lg fw-bold">
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