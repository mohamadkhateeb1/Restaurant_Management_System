@extends('layouts.app')

@section('title', 'معلومة الموظف: ' . $employee->name)

@section('content')

    <div class="container-fluid py-4">

        {{-- اسم الموظف وزر للعودة الى الداش بورد--}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 text-light">
                ملف الموظف: <span class="text-info">{{ $employee->name }}</span>
            </h2>
            {{-- زر العودة للداش بورد  --}}
            <a href="{{ route('Admin.employee.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-right me-2"></i>
                العودة للقائمة
            </a>
        </div>
        
        {{-- بحال كنت بدي شوف بيانات موظف وحبيت عدل--}}
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('Admin.employee.edit', $employee->id) }}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit me-2"></i>
                تعديل بيانات الموظف
            </a>
        </div>

        <div class="card bg-dark shadow-lg border-0">
            <div class="card-body">

                <div class="row">
                    
                    {{-- القسم الأول: بيانات الاتصال والشخصية --}}
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="card bg-gray-700 h-100 p-3 border-info border-3">
                            <h5 class="card-title text-info border-bottom pb-2 mb-3">
                                <i class="fas fa-user me-2"></i> بيانات الاتصال الشخصية
                            </h5>
                            
                            <p class="text-light mb-2">
                                <strong>الاسم الكامل:</strong> <span class="fw-bold">{{ $employee->name }}</span>
                            </p>
                            <p class="text-light mb-2">
                                <strong>البريد الإلكتروني:</strong> <span class="text-warning">{{ $employee->email }}</span>
                            </p>
                            <p class="text-light mb-2">
                                <strong>رقم الهاتف:</strong> {{ $employee->phone }}
                            </p>
                            <p class="text-light mb-2">
                                <strong>تاريخ الانضمام:</strong> {{ $employee->created_at->format('Y-m-d') }}
                            </p>
                            <p class="text-light mb-0">
                                <strong>الحالة:</strong>
                                @if ($employee->status == 'active')
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-danger">غير نشط</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="row">


                            <div class="col-lg-6 mb-3">
                                <div class="card text-white bg-primary shadow">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-white-50">الوظيفة الحالية</h6>
                                        <h3 class="card-title fw-bold">{{ $employee->position }}</h3>
                                        <i class="fas fa-briefcase fa-2x position-absolute" style="top: 15px; left: 15px; opacity: 0.2;"></i>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-lg-6 mb-3">
                                <div class="card text-white bg-success shadow">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-white-50">الراتب الشهري</h6>
                                        <h3 class="card-title fw-bold">
                                            {{ number_format($employee->salary, 2) }} ريال
                                        </h3>
                                        <i class="fas fa-dollar-sign fa-2x position-absolute" style="top: 15px; left: 15px; opacity: 0.2;"></i>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-lg-6 mb-3">
                                <div class="card text-white bg-info shadow">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-white-50">تاريخ التوظيف</h6>
                                        <h3 class="card-title fw-bold">{{ $employee->hire_date }}</h3>
                                        <i class="fas fa-calendar-alt fa-2x position-absolute" style="top: 15px; left: 15px; opacity: 0.2;"></i>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- بطاقة لعدد أيام العمل منذ تاريخ التوظيف--}}
                            <div class="col-lg-6 mb-3">
                                <div class="card text-white bg-secondary shadow">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-white-50">عدد أيام العمل</h6>
                                        <h3 class="card-title fw-bold">
                                            {{ now()->diffInDays($employee->hire_date) }} يوم

                                        </h3>
                                        <i class="fas fa-clock fa-2x position-absolute" style="top: 15px; left: 15px; opacity: 0.2;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if ($employee->notes)
                        <div class="col-12 mt-4">
                            <div class="card bg-secondary p-3 border-0">
                                <h5 class="card-title text-light border-bottom pb-2 mb-3">
                                    <i class="fas fa-comment-dots me-2"></i> ملاحظات الإدارة
                                </h5>
                                <p class="text-white-75">{{ $employee->notes }}</p>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection