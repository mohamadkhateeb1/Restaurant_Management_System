@extends('layouts.app') 

@section('title', 'Restaurant Admin Dashboard')
@section('content')

<div class="container-fluid">

    {{-- قسم الإحصائيات (KPIs) --}}
    <div class="row mb-4">
        
        {{-- بطاقة 1: المبيعات اليومية --}}
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>$2,450</h3>
                    <p>المبيعات اليومية</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="#" class="small-box-footer">
                    <i class="fas fa-arrow-up"></i> 15% من أمس
                </a>
            </div>
        </div>

        {{-- بطاقة 2: الطلبات المكتملة --}}
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>450</h3>
                    <p>الطلبات المكتملة (شهر)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <a href="#" class="small-box-footer">
                    معدل الإنجاز 98%
                </a>
            </div>
        </div>

        {{-- بطاقة 3: الموظفون النشطون --}}

        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>15</h3>
                    <p>الموظفون النشطون</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">
                    12 نادل، 3 مطبخ
                </a>
            </div>
        </div>

        {{-- بطاقة 4: متوسط التقييم --}}
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>4.7 / 5.0</h3>
                    <p>متوسط التقييم</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <a href="#" class="small-box-footer">
                    بناءً على 50 تقييماً
                </a>
            </div>
        </div>
    </div>

{{-- ---------------------------Table Users ---------------- --}}
    <div class="row">
        <div class="col-12">
            <div class="card card-dark">
                
                {{-- Header الكارت --}}
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users ml-2"></i>
                        جدول المستخدمين (بيانات ثابتة)
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info">3 مستخدمين</span>
                    </div>
                </div>

                {{-- Body الكارت --}}
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-dark text-nowrap">
                        <thead>
                            <tr>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                                <th>رقم الهاتف</th>
                                <th class="text-center">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                         
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-panel d-flex">
                                            <div class="image">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white font-weight-bold">أ</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="mr-2 font-weight-bold">أحمد الشريف</span>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-envelope text-info ml-2"></i>
                                    ahmad@example.com
                                </td>
                                <td>
                                    <span class="badge badge-purple">
                                        <i class="fas fa-user-shield ml-1"></i>
                                        مدير
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-phone ml-2"></i>
                                    501234567
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle ml-1"></i>
                                        نشط
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-panel d-flex">
                                            <div class="image">
                                                <div class="bg-pink rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white font-weight-bold">ف</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="mr-2 font-weight-bold">فاطمة محمد</span>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-envelope text-info ml-2"></i>
                                    fatima@example.com
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <i class="fas fa-concierge-bell ml-1"></i>
                                        نادل
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-phone ml-2"></i>
                                    559876543
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock ml-1"></i>
                                        إجازة
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-panel d-flex">
                                            <div class="image">
                                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white font-weight-bold">خ</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="mr-2 font-weight-bold">خالد العلي</span>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-envelope text-info ml-2"></i>
                                    khalid@example.com
                                </td>
                                <td>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-fire ml-1"></i>
                                        طباخ
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-phone ml-2"></i>
                                    530001112
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle ml-1"></i>
                                        نشط
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        <small class="text-muted">
                            عرض <strong>3</strong> من <strong>3</strong> مستخدمين
                        </small>
                    </div>
                    <ul class="pagination pagination-sm m-0 float-left">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .badge-purple {
        background-color: #6f42c1;
        color: white;
    }
    
    .bg-pink {
        background-color: #e83e8c !important;
    }
    
    .small-box .icon {
        left: 10px;
        right: auto;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(255,255,255,0.05);
    }
</style>
@endpush
@endsection