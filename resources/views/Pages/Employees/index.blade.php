@extends('layouts.app')
@section('title', __('إدارة الموظفين'))

@section('content')

    <style>
        /* ===== DASHBOARD THEME ===== */
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
                transform: translateY(15px)
            }

            to {
                opacity: 1
            }
        }

        .glass-card {
            background: linear-gradient(180deg, #0b0d10, #141821);
            border: 1px solid var(--gold-soft);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .55);
        }

        .text-gold {
            color: var(--gold)
        }

        .fw-black {
            font-weight: 900
        }

        /* ===== TABLE ===== */
        .table-dark {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(255, 255, 255, .03);
            --bs-table-hover-bg: rgba(212, 175, 55, .08);
            border-color: var(--border-soft);
        }

        .table thead th {
            color: #b5b5b5;
            font-size: .75rem;
            letter-spacing: .08em;
            border-bottom: 1px solid var(--border-soft);
        }

        .table tbody tr {
            transition: .25s ease;
        }

        .table tbody tr:hover {
            transform: translateX(-4px);
        }

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

        /* ===== ACTIONS ===== */
        .action-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: .25s ease;
        }

        .action-btn:hover {
            background: rgba(212, 175, 55, .15);
            transform: translateY(-2px);
        }
    </style>

    <div class="page-wrapper">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-black text-gold mb-0">
                <i class="fas fa-users-cog me-2"></i>
                @lang('Employees List')
            </h2>

            @can('create', App\Models\Employee::class)
                <a href="{{ route('Pages.employee.create') }}" class="btn btn-outline-warning px-4">
                    <i class="fas fa-user-plus me-2"></i>
                    @lang('Add New Employee')
                </a>
            @endcan
        </div>

        <x-flash_message />

        {{-- TABLE CARD --}}
        <div class="glass-card">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">@lang('Name')</th>
                            <th>@lang('Position')</th>
                            <th>@lang('Phone')</th>
                            <th>@lang('Salary')</th>
                            <th>@lang('Hire Date')</th>
                            {{-- <th>@lang('Status')</th> --}}
                            <th class="text-center pe-4">@lang('Actions')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $employee)
                            @if ($employee->super_admin)
                                @continue
                            @endif

                            <tr>
                                <td class="ps-4 fw-bold text-white">
                                    {{ $employee->name }}
                                </td>

                                <td>
                                    <span class="badge bg-secondary bg-opacity-25 text-light px-3">
                                        {{ $positions[$employee->position] ?? $employee->position }}
                                    </span>
                                </td>

                                <td class="text-white-50">{{ $employee->phone }}</td>

                                <td class="fw-bold text-gold">
                                    {{ number_format($employee->salary, 2) }}
                                </td>

                                <td class="text-white-50">{{ $employee->hire_date }}</td>

                                {{-- <td>
                                    @if ($employee->status === 'active')
                                        <span class="badge-soft-success px-3 py-1 rounded-pill">نشط</span>
                                    @else
                                        <span class="badge-soft-danger px-3 py-1 rounded-pill">غير نشط</span>
                                    @endif
                                </td> --}}

                                <td class="pe-4">
                                    <div class="d-flex justify-content-center gap-2">

                                        @can('view', App\Models\Employee::class)
                                            <a href="{{ route('Pages.employee.show', $employee->id) }}"
                                                class="action-btn text-info" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan

                                        @can('update', App\Models\Employee::class)
                                            <a href="{{ route('Pages.employee.edit', $employee->id) }}"
                                                class="action-btn text-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete', App\Models\Employee::class)
                                            <form method="POST" action="{{ route('Pages.employee.destroy', $employee->id) }}"
                                                onsubmit="return confirm('هل أنت متأكد من حذف {{ $employee->name }}؟')">
                                                @csrf @method('DELETE')
                                                <button class="action-btn text-danger border-0 bg-transparent">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-user-slash fa-3x mb-3 d-block"></i>
                                    لا يوجد موظفين حالياً
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
