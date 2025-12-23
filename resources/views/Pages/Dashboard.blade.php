@extends('layouts.app')

@section('title', __('app.home'))
@section('content')

    <div class="container-fluid">

        {{-- 1. قسم الإحصائيات الرئيسية (KPIs) --}}
        <h3 class="mt-2 mb-4 animated-title">📈 مؤشرات الأداء الرئيسية (KPIs)</h3>
        <div class="row mb-4">

            {{-- بطاقة 1: المبيعات اليومية --}}
            <div class="col-lg-3 col-md-6 col-12 mb-3">
                <div class="small-box bg-success animated-kpi">
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
                <div class="small-box bg-info animated-kpi" style="animation-delay: 0.1s;">
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
                <div class="small-box bg-warning animated-kpi" style="animation-delay: 0.2s;">
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
                <div class="small-box bg-danger animated-kpi" style="animation-delay: 0.3s;">
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



        {{-- 2. قسم الجداول (المستخدمين والموظفين) --}}
        <h3 class="mt-4 mb-4 animated-title" style="animation-delay: 0.4s;">📋 بيانات المستخدمين والموظفين</h3>

        {{-- ---------------------------Table Users ---------------- --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card animated-kpi" style="animation-delay: 0.5s;">

                    {{-- Header الكارت --}}
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-shield ml-2"></i>
                            جدول المستخدمين
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-info">3 مستخدمين</span>
                        </div>
                    </div>

                    {{-- Body الكارت --}}
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped text-nowrap">
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
                                            <i class="fas fa-hat-chef ml-1"></i>
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

                    {{-- <div class="card-footer clearfix">
                        <div class="float-right">
                            <small class="text-muted">
                                مثال: يوضح هذا الجدول صلاحيات المستخدمين وحالاتهم.
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
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- ---------------------------Table Employees ---------------- --}}
        <div class="row mt-4">
            <div class="col-12 mb-4">
                <div class="card animated-kpi" style="animation-delay: 0.6s;">

                    {{-- Header الكارت --}}
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users-cog ml-2"></i>
                            جدول الموظفين
                        </h3>
                        {{-- @foreach ($employees as $employee) --}}
                        <div class="card-tools">
                            <span class="badge badge-warning">4 موظفين</span>
                        </div>
                    </div>

                    {{-- Body الكارت --}}
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>الوظيفة</th>
                                    <th>تاريخ الانضمام</th>
                                    <th>ساعات العمل</th>
                                    <th class="text-center">الراتب الشهري</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>احمد</td>
                                    <td>مدير مطعم</td>
                                    <td>2022-01-15</td>
                                    <td>8 ساعات</td>
                                    <td class="text-center">6,500 ر.س</td>
                                </tr>
                                <tr>
                                    <td>سارة فهد</td>
                                    <td>رئيس الطهاة</td>
                                    <td>2021-08-20</td>
                                    <td>9 ساعات</td>
                                    <td class="text-center">7,200 ر.س</td>
                                </tr>
                                <tr>
                                    <td>يوسف خالد</td>
                                    <td>نادل</td>
                                    <td>2023-05-10</td>
                                    <td>7 ساعات</td>
                                    <td class="text-center">3,500 ر.س</td>
                                </tr>
                                <tr>
                                    <td>نورة جمال</td>
                                    <td>محاسب</td>
                                    <td>2024-02-01</td>
                                    <td>8 ساعات</td>
                                    <td class="text-center">5,800 ر.س</td>
                                </tr>
                            </tbody>
                            {{-- @endforeach --}}
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            <small class="text-muted">
                                مثال: لتتبع دوام الموظفين ومعدلات الرواتب.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            @keyframes fadeInUp {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animated-title,
            .animated-kpi {
                animation: fadeInUp 0.5s ease-out both;
            }

            body:not(.dark-mode) {
                background-color: #f4f6f9;
                color: #343a40;
            }

            body:not(.dark-mode) .content-wrapper {
                background-color: transparent !important;
            }

            body,
            .content-wrapper,
            .main-header,
            .main-sidebar,
            .card {
                transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            }


            .small-box {
                box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 3px 6px rgba(0, 0, 0, .2) !important;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .small-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 8px 16px rgba(0, 0, 0, .3) !important;
            }

            .dark-mode .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(255, 255, 255, 0.05);
            }

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
        </style>
    @endpush

@endsection
