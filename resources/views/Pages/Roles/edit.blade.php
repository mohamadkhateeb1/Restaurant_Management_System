@extends('Layouts.app')

@section('title', 'Edit Role: ' . $role->name)

@section('content')
    <form action="{{ route('Pages.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container-fluid py-4" dir="rtl">

            {{-- HEADER / ACTION BAR --}}
            <div class="sticky-action-bar mb-4">
                <div
                    class="luxury-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 shadow-lg">
                    <div>
                        <h4 class="mb-1 text-white fw-light">
                            <i class="fas fa-user-edit text-gold me-2"></i>تحديث كيان الصلاحية
                        </h4>
                        <small class="text-muted">
                            تعديل الأذونات الخاصة بـ: <b class="text-gold fw-bold">{{ $role->name }}</b>
                        </small>
                    </div>

                    <div class="d-flex gap-2 action-btns">
                        <a href="{{ route('Pages.roles.index') }}"
                            class="btn btn-outline-light border-opacity-25 rounded-pill px-4 py-2 fw-light transition-all flex-grow-1">
                            <i class="fas fa-arrow-right me-1 small"></i> عودة
                        </a>
                        <button type="submit"
                            class="btn btn-luxury-gold px-4 py-2 rounded-pill fw-bold shadow flex-grow-1">
                            <i class="fas fa-sync-alt me-1"></i> حفظ المزامنة
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-10 col-lg-11 mx-auto">

                    {{-- ERRORS --}}
                    @if ($errors->any())
                        <div class="alert luxury-alert border-0 mb-4 animate__animated animate__shakeX">
                            <div class="d-flex align-items-center text-white">
                                <i class="fas fa-exclamation-triangle text-gold me-3 fa-lg"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold text-gold">بيانات ناقصة!</h6>
                                    <ul class="mb-0 small opacity-75">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- MAIN CARD --}}
                    <div class="card luxury-card border-0 shadow-lg overflow-hidden">
                        <div
                            class="card-header border-bottom border-white border-opacity-10 py-4 bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h6 class="mb-0 fw-light text-gold text-uppercase" style="letter-spacing: 2px;">
                                <span class="badge bg-gold-soft text-gold rounded-pill px-3 py-1 me-2"
                                    style="font-size: 10px;">وضع التعديل</span>
                                مصفوفة تعديل الأذونات
                            </h6>
                            <div class="extra-small text-muted font-monospace">
                                المعرف الفريد: <span class="text-white">#{{ $role->id }}</span>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="p-4 p-md-5">
                                @include('Pages.Roles._form')
                            </div>
                        </div>

                        <div
                            class="card-footer bg-transparent py-4 border-top border-white border-opacity-10 text-center text-muted extra-small">
                            <i class="fas fa-info-circle me-1 opacity-50"></i> تنبيه: تحديث هذا الدور سيؤثر فوراً على جميع
                            الموظفين المرتبطين به.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        :root {
            --gold-primary: #c5a059;
            --gold-secondary: #8e6d3d;
            --dark-bg: #0a0a0a;
            --card-bg: #141414;
            --glass-border: rgba(255, 255, 255, 0.03);
            --text-muted: #7a7a7a;
            --gold-soft: rgba(197, 160, 89, 0.1);
        }

        body {
            background-color: var(--dark-bg);
            background-image: radial-gradient(circle at 2px 2px, #1a1a1a 1px, transparent 0);
            background-size: 30px 30px;
        }

        /* STICKY BAR */
        .sticky-action-bar {
            position: sticky;
            top: 10px;
            z-index: 1020;
        }

        .luxury-header {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 20px 25px;
        }

        /* BUTTONS */
        .btn-luxury-gold {
            background: linear-gradient(145deg, var(--gold-primary), var(--gold-secondary)) !important;
            color: #000 !important;
            border: none !important;
            transition: 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .btn-luxury-gold:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 5px 15px rgba(197, 160, 89, 0.3) !important;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--gold-primary) !important;
            color: var(--gold-primary);
        }

        /* CARD & ALERTS */
        .luxury-card {
            background: var(--card-bg) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 30px !important;
        }

        .luxury-alert {
            background: rgba(197, 160, 89, 0.05);
            border-right: 4px solid var(--gold-primary) !important;
            border-radius: 15px;
        }

        .bg-gold-soft {
            background-color: var(--gold-soft);
        }

        .text-gold {
            color: var(--gold-primary) !important;
        }

        .extra-small {
            font-size: 0.75rem;
        }

        .fw-light {
            font-weight: 300 !important;
        }

        /* RESPONSIVE MEDIA QUERIES */
        @media (max-width: 768px) {
            .luxury-header {
                padding: 15px;
                text-align: center;
            }

            .action-btns {
                width: 100%;
            }

            .card-header h6 {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .sticky-action-bar {
                position: relative;
                top: 0;
            }

            .p-4 {
                padding: 1.5rem !important;
            }
        }
    </style>
@endpush
