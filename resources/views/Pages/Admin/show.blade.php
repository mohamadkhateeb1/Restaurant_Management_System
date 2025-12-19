@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3 bg-primary text-white text-center py-5 rounded-left">
                                <img class="profile-user-img img-fluid img-circle border-white mb-3 shadow"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=fff&color=007bff&size=128"
                                    alt="User profile picture" style="width: 90px; border: 3px solid;">
                                <h4 class="mb-1 font-weight-bold">{{ $admin->name }}</h4>
                                <span class="badge badge-light text-primary px-3 shadow-sm">Admin Account</span>
                            </div>

                            <div class="col-md-6 px-4 py-3 border-right">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <small class="text-muted d-block mb-1 font-weight-bold"><i
                                                class="fas fa-envelope mr-1"></i> البريد الإلكتروني</small>
                                        <p class="mb-0 text-dark font-weight-600">{{ $admin->email }}</p>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <small class="text-muted d-block mb-1 font-weight-bold"><i
                                                class="fas fa-id-badge mr-1"></i> المعرف (ID)</small>
                                        <p class="mb-0 text-dark font-weight-600">#{{ $admin->id }}</p>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <small class="text-muted d-block mb-2 font-weight-bold"><i
                                                class="fas fa-user-tag mr-1"></i> الأدوار النشطة</small>
                                        <div class="d-flex flex-wrap">
                                            @forelse($admin->roles as $role)
                                                <span
                                                    class="badge badge-soft-primary py-2 px-3 mr-2 mb-2 text-primary border"
                                                    style="background: #f0f7ff;">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted small">لا يوجد أدوار موكلة</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 text-center px-4 py-3">
                                <a href="{{ route('Pages.admin.edit', $admin->id) }}"
                                    class="btn btn-primary btn-block mb-2 shadow-sm">
                                    <i class="fas fa-user-edit mr-2"></i> تعديل الحساب
                                </a>
                                <a href="{{ route('Pages.admin.index') }}" class="btn btn-outline-secondary btn-block">
                                    <i class="fas fa-arrow-left mr-2"></i> رجوع للقائمة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-shield-alt text-success mr-2"></i> مصفوفة الصلاحيات الممنوحة
                        </h5>
                    </div>

                    <div class="card-body p-0">
                        @php
                            $groupedAbilities = []; // تجميع الصلاحيات حسب المجموعات
                            foreach (config('abilities') as $code => $name) {
                                // جلب جميع الصلاحيات من ملف الإعدادات
                                if ($admin->hasAbility($code)) {
                                    // التحقق مما إذا كان الأدمن يمتلك الصلاحية
                                    $prefix = explode('.', $code)[0] ?? 'Other'; // استخراج البادئة لتجميع الصلاحيات
                                    $groupedAbilities[$prefix][$code] = $name; // تجميع الصلاحيات حسب البادئة
                                }
                            }
                        @endphp
                        {{-- تجميع الصلاحيات حسب المجموعات --}}
                        @foreach($groupedAbilities as $groupName => $abilities)
                            <div class="permission-row border-bottom last-child-border-0">
                                <div class="row no-gutters align-items-stretch">
                                    <div
                                        class="col-md-2 bg-light d-flex align-items-center justify-content-center border-right">
                                        <span class="text-dark font-weight-bold text-uppercase small text-center p-2"
                                            style="letter-spacing: 0.5px;">
                                            {{ $groupName }}
                                        </span>
                                    </div>
                                    <div class="col-md-10 p-3">
                                        <div class="row">
                                            @foreach ($abilities as $code => $name)
                                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                                    <div class="p-2 border rounded bg-white shadow-xs d-flex align-items-center h-100"
                                                        style="border-left: 4px solid #28a745 !important; transition: all 0.2s ease-in-out;">
                                                        <div class="icon-box mr-2 text-success" style="font-size: 1.1rem;">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                        <div class="overflow-hidden">
                                                            <h6 class="mb-0 font-weight-bold text-dark x-small-text">
                                                                {{ $name }}</h6>
                                                            <small
                                                                class="text-muted d-block x-tiny-text">{{ $code }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .font-weight-600 {
                font-weight: 600;
            }

            .shadow-xs {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            }

            .x-small-text {
                font-size: 0.85rem;
                line-height: 1.2;
            }

            .x-tiny-text {
                font-size: 0.7rem;
            }

            .last-child-border-0:last-child {
                border-bottom: none !important;
            }

            .shadow-xs:hover {
                transform: scale(1.03);
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05) !important;
                background: #f8fff9 !important;
            }

            .rounded-left {
                border-radius: 0.35rem 0 0 0.35rem;
            }

            @media (max-width: 768px) {
                .rounded-left {
                    border-radius: 0.35rem 0.35rem 0 0;
                }

                .border-right {
                    border-right: none !important;
                    border-bottom: 1px solid #eee;
                }
            }
        </style>
    @endpush
@endsection
