@extends('Layouts.app')

@section('title', 'Create Role')

@section('content')
    <form action="{{ route('Pages.roles.store') }}" method="POST">
        @csrf
        <div class="container-fluid py-4" dir="rtl">
            {{-- HEADER / ACTION BAR --}}
            <div class="sticky-action-bar mb-4">
                <div
                    class="luxury-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 shadow-lg">
                    <div>
                        <h4 class="mb-1 text-white fw-light">
                            <i class="fas fa-plus-circle text-gold me-2"></i>@lang('New Role Registration')
                        </h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 m-0 extra-small">
                                <li class="breadcrumb-item"><a href="{{ route('Pages.roles.index') }}"
                                        class="text-gold opacity-75 text-decoration-none">@lang('Roles')</a></li>
                                <li class="breadcrumb-item active text-white-50" aria-current="page">@lang('New Role Registration')</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex gap-2 action-btns">
                        <a href="{{ route('Pages.roles.index') }}"
                            class="btn btn-outline-light border-opacity-25 rounded-pill px-4 py-2 fw-light transition-all flex-grow-1">
                            <i class="fas fa-arrow-right me-1 small"></i> @lang('Back')
                        </a>
                        <button type="submit"
                            class="btn btn-luxury-gold px-4 py-2 rounded-pill fw-bold shadow flex-grow-1">
                            <i class="fas fa-check-double me-1"></i> @lang('Save Role')
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-10 col-lg-11 mx-auto">

                    {{-- ERROR ALERTS --}}
                    @if ($errors->any())
                        <div class="alert luxury-alert border-0 mb-4 animate__animated animate__shakeX">
                            <div class="d-flex align-items-center text-white">
                                <i class="fas fa-exclamation-gold me-3 fa-lg"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold text-gold">@lang('Missing Information')!</h6>
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
                        <div class="card-header border-bottom border-white border-opacity-10 py-4 bg-transparent">
                            <h6 class="mb-0 fw-light text-gold text-uppercase" style="letter-spacing: 2px;">
                                <i class="fas fa-shield-alt me-2"></i>@lang('Define Role & Set Permissions')
                            </h6>
                        </div>

                        <div class="card-body p-0">
                            {{-- هذا الجزء يضم مدخلات الاسم والصلاحيات --}}
                            <div class="p-4 p-md-5">
                                @include('Pages.Roles._form')
                            </div>
                        </div>

                        <div class="card-footer bg-transparent py-4 border-top border-white border-opacity-10 text-center text-muted extra-small text-uppercase"
                            style="letter-spacing: 1px;">
                            @lang('Secure System Access Configuration')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --gold-primary: #c5a059;
            --gold-secondary: #8e6d3d;
            --dark-bg: #0a0a0a;
            --card-bg: #141414;
            --glass-border: rgba(255, 255, 255, 0.03);
            --text-muted: #7a7a7a;
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

        /* CARD */
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

        /* TEXT UTILITIES */
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

            .p-4 {
                padding: 1.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .breadcrumb {
                justify-content: center;
            }

            .sticky-action-bar {
                position: relative;
                top: 0;
            }
        }

        /* تحسين شكل المدخلات داخل الـ Form المضمن */
        .form-control,
        .form-select {
            background-color: #0c0c0c !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            border-radius: 12px;
        }

        .form-control:focus {
            border-color: var(--gold-primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.1);
        }
    </style>
@endpush
