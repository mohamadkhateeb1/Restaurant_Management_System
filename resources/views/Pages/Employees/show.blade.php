@extends('layouts.app')
@section('title', __('ملف الموظف') . ': ' . $employee->name)

@section('content')

    <style>
        :root {
            --gold: #d4af37;
            --gold-soft: rgba(212, 175, 55, .25);
            --dark-1: #0b0d10;
            --dark-2: #141821;
            --border-soft: rgba(255, 255, 255, .08);
        }

        .page-wrapper {
            padding: 24px;
            background: linear-gradient(180deg, var(--dark-1), var(--dark-2));
            min-height: 100%;
            animation: fadeIn .6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1
            }
        }

        .glass-card {
            background: linear-gradient(180deg, #0b0d10, #141821);
            border: 1px solid var(--gold-soft);
            border-radius: 22px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, .6);
        }

        .text-gold {
            color: var(--gold)
        }

        .fw-black {
            font-weight: 900
        }

        /* ===== PROFILE ===== */
        .profile-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: radial-gradient(circle, #d4af37, #8f6b18);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(212, 175, 55, .45);
        }

        .profile-avatar i {
            font-size: 3rem;
            color: #0b0d10;
        }

        /* ===== INFO CARDS ===== */
        .info-card {
            padding: 22px;
            border-radius: 18px;
            background: linear-gradient(145deg, #0f131b, #0b0d10);
            border: 1px solid rgba(212, 175, 55, .18);
            transition: .35s ease;
        }

        .info-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, .6), 0 0 20px rgba(212, 175, 55, .25);
        }

        .info-label {
            font-size: .75rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(212, 175, 55, .65);
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 1.35rem;
            font-weight: 900;
            color: #fff;
        }

        .info-value.gold {
            color: var(--gold)
        }

        .info-value.muted {
            color: #cbd5e1
        }

        /* ===== BADGES ===== */
        .badge-soft-success {
            background: rgba(34, 197, 94, .15);
            color: #22c55e;
            border: 1px solid #22c55e;
        }

        .badge-soft-danger {
            background: rgba(239, 68, 68, .15);
            color: #ef4444;
            border: 1px solid #ef4444;
        }

        .badge-soft-gold {
            background: rgba(212, 175, 55, .15);
            color: var(--gold);
            border: 1px solid var(--gold);
        }

        /* ===== NOTES ===== */
        .notes-box {
            background: rgba(255, 255, 255, .04);
            border: 1px dashed var(--gold-soft);
            border-radius: 16px;
        }
    </style>

    <div class="page-wrapper">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-black text-gold mb-0">
                <i class="fas fa-id-badge me-2"></i>
               @lang('Employee Profile')
            </h2>

            <div class="d-flex gap-2">
                <a href="{{ route('Pages.employee.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-right me-2"></i>@lang('Back')
                </a>

                @can('update', App\Models\Employee::class)
                    <a href="{{ route('Pages.employee.edit', $employee->id) }}" class="btn btn-outline-warning px-4">
                        <i class="fas fa-edit me-2"></i>@lang('Edit')
                    </a>
                @endcan
            </div>
        </div>

        <div class="row g-4">

            {{-- LEFT PROFILE --}}
            <div class="col-lg-4">
                <div class="glass-card p-4 text-center h-100">
                    <div class="profile-avatar mx-auto mb-3">
                        <i class="fas fa-user"></i>
                    </div>

                    <h3 class="fw-black text-white mb-1">{{ $employee->name }}</h3>
                    <div class="text-gold fw-bold mb-3">{{ $employee->position }}</div>

                    <hr class="border-secondary">

                    <div class="text-start">

                        <div class="mb-3">
                            <small class="info-label">@lang('Email')</small>
                            <span class="text-gold">{{ $employee->email }}</span>
                        </div>

                        <div class="mb-3">
                            <small class="info-label">@lang('Phone Number')</small>
                            <span class="text-white">{{ $employee->phone }}</span>
                        </div>


                        <div>
                            <small class="info-label">@lang('Roles')</small>
                            @forelse($employee->roles as $role)
                                <span class="badge-soft-gold px-3 py-1 rounded-pill me-1">
                                    <i class="fas fa-shield-alt me-1"></i>{{ $role->name }}
                                </span>
                            @empty
                                <small class="text-muted">لا توجد أدوار</small>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT INFO --}}
            <div class="col-lg-8">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">@lang('Job Title')</div>
                            <div class="info-value">{{ $employee->position }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">@lang('Monthly Salary')</div>
                            <div class="info-value gold">
                                {{ number_format($employee->salary, 2) }} SAR
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">@lang('Hire Date')</div>
                            <div class="info-value muted">{{ $employee->hire_date }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">@lang('Service Duration')</div>
                            <div class="info-value">
                                {{ now()->diffInDays($employee->hire_date) }} يوم
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="glass-card p-4 notes-box">
                            <h5 class="text-gold mb-3">
                                <i class="fas fa-sticky-note me-2"></i> @lang('Notes HR')
                            </h5>

                            @if ($employee->notes)
                                <p class="text-white-50 lh-lg mb-0">{{ $employee->notes }}</p>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-comment-slash fa-2x mb-2"></i>
                                    <div>لا توجد ملاحظات</div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
