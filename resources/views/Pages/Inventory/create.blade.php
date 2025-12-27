@extends('layouts.app')

@section('content')
    <div class="container py-5" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                {{-- بطاقة الإضافة بتصميم Dark Glassmorphism المطور --}}
                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden animate-slide-up" style="background: #0d0f11;">

                    {{-- هيدر البطاقة الفاخر بتدرج لوني عميق --}}
                    <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(135deg, #16191c 0%, #000000 100%); border-bottom: 1px solid rgba(255,255,255,0.05) !important;">
                        <div class="d-flex align-items-center">
                            <div class="icon-badge-premium me-3">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold text-white fs-5">إضافة مادة مخزنية</h4>
                                <p class="text-muted small mb-0 opacity-75">إدراج صنف جديد في قاعدة بيانات المستودع المركزي
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('Pages.inventory.index') }}" class="btn-close-premium transition-all">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        {{-- رسائل الخطأ بتنسيق Neon --}}
                        @if ($errors->any())
                            <div class="alert alert-custom-danger border-0 rounded-4 shadow-sm mb-5 animate-pulse">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                                    <ul class="mb-0 small fw-bold list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- تفعيل enctype لرفع الصور --}}
                        <form action="{{ route('Pages.inventory.store') }}" method="POST" enctype="multipart/form-data"
                            class="premium-form">
                            @csrf

                            {{-- مجموعة البيانات الأساسية --}}
                            <div class="form-section-wrapper mb-5">
                                <div class="section-header-tag mb-4">
                                    <i class="fas fa-database me-2"></i> مواصفات الصنف
                                </div>

                                <div class="section-content-box p-4 rounded-4 shadow-inner">
                                    {{-- استدعاء ملف الحقول المحدث --}}
                                    @include('Pages.Inventory._form')
                                </div>
                            </div>

                            {{-- أزرار التحكم بتنسيق عائم --}}
                            <div
                                class="form-footer-actions mt-5 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center border-top border-white border-opacity-10">
                                <div class="text-muted small mb-3 mb-md-0 fw-600">
                                    <i class="fas fa-info-circle me-1 text-primary"></i> تأكد من صحة الكميات والوحدات قبل
                                    الحفظ.
                                </div>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('Pages.inventory.index') }}"
                                        class="btn btn-dark-minimal rounded-pill px-5 py-3 fw-bold">
                                        تراجع
                                    </a>
                                    <button type="submit"
                                        class="btn btn-neon-save rounded-pill px-5 py-3 fw-bold shadow-glow transition-up">
                                        <i class="fas fa-check-circle me-2"></i> اعتماد وإضافة المادة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');

        body {
            background-color: #08090a;
            font-family: 'Cairo', sans-serif;
            color: #e1e1e1;
        }

        /* ظل وظلال عميقة */
        .shadow-2xl {
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.9);
        }

        .shadow-inner {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        /* أيقونة الهيدر */
        .icon-badge-premium {
            width: 48px;
            height: 48px;
            background: rgba(0, 210, 255, 0.1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0, 210, 255, 0.2);
            color: #00d2ff;
            font-size: 1.4rem;
        }

        /* زر الإغلاق */
        .btn-close-premium {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .btn-close-premium:hover {
            background: #ff3e3e;
            color: white;
            transform: rotate(90deg);
            box-shadow: 0 0 15px rgba(255, 62, 62, 0.4);
        }

        /* وسوم الأقسام */
        .section-header-tag {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(0, 210, 255, 0.05);
            color: #00d2ff;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(0, 210, 255, 0.1);
        }

        /* الأزرار المطورة */
        .btn-neon-save {
            background: #00d2ff;
            color: #000;
            border: none;
            transition: 0.4s;
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.3);
        }

        .btn-neon-save:hover {
            background: #fff;
            transform: translateY(-4px);
            box-shadow: 0 0 30px #00d2ff;
        }

        .btn-dark-minimal {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #888;
            transition: 0.3s;
        }

        .btn-dark-minimal:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-color: #fff;
        }

        /* التنبيهات */
        .alert-custom-danger {
            background: rgba(255, 62, 62, 0.08);
            color: #ff3e3e;
            border: 1px solid rgba(255, 62, 62, 0.2);
            border-right: 5px solid #ff3e3e;
        }

        /* المزامنة مع الحقول الكربونية */
        .premium-form .form-control-dark,
        .premium-form .form-select-dark {
            background-color: #1a1d21 !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            color: #fff !important;
            border-radius: 12px;
            padding: 14px;
        }

        /* أنيميشن */
        .animate-slide-up {
            animation: slideUp 0.8s cubic-bezier(0.2, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* إخفاء الأقسام القديمة */
        .premium-form div[class*="border-primary"][class*="bg-primary"] {
            display: none !important;
        }
    </style>
@endsection
