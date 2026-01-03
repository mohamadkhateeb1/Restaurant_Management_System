@extends('Layouts.app')
@section('title', 'تفاصيل صلاحيات الدور')

@section('content')
    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="sticky-action-bar mb-4">
            <div class="header-dark d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div>
                    <h4 class="mb-1 fw-bold text-light">
                        <i class="fas fa-shield-alt text-neon me-2"></i>
                        صلاحيات الدور: {{ $role->name }}
                    </h4>
                    <p class="mb-1 fw-bold text-light">
                        عرض الصلاحيات الفعلية المطبقة على هذا الدور
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('Pages.roles.index') }}" class="btn btn-dark-outline">
                        <i class="fas fa-arrow-left me-1"></i> رجوع
                    </a>

                    @can('update', App\Models\Role::class)
                        <a href="{{ route('Pages.roles.edit', $role->id) }}" class="btn btn-edit-role">
                            <i class="fas fa-edit me-1"></i> تعديل
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        {{-- CARDS --}}
        <div class="row g-4">

            {{-- ALLOW --}}
            <div class="col-md-4">
                <div class="permission-card allow">
                    <div class="card-header">
                        <i class="fas fa-check-circle"></i> Allow
                    </div>
                    <ul class="permission-list">
                        @forelse ($role->abilities->where('type', 'allow') as $ability)
                            <li>
                                <span>{{ config('abilities')[$ability->ability] ?? $ability->ability }}</span>
                                <code>{{ $ability->ability }}</code>
                            </li>
                        @empty
                            <li class="empty">لا توجد صلاحيات مسموحة</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- DENY --}}
            <div class="col-md-4">
                <div class="permission-card deny">
                    <div class="card-header">
                        <i class="fas fa-times-circle"></i> Deny
                    </div>
                    <ul class="permission-list">
                        @forelse ($role->abilities->where('type', 'deny') as $ability)
                            <li>
                                <span>{{ config('abilities')[$ability->ability] ?? $ability->ability }}</span>
                                <code>{{ $ability->ability }}</code>
                            </li>
                        @empty
                            <li class="empty">لا توجد صلاحيات مرفوضة</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- INHERIT --}}
            <div class="col-md-4">
                <div class="permission-card inherit">
                    <div class="card-header">
                        <i class="fas fa-minus-circle"></i> Inherit
                    </div>
                    <ul class="permission-list">
                        @foreach (config('abilities') as $code => $name)
                            @if (
                                !$role->abilities->where('ability', $code)->first() ||
                                    $role->abilities->where('ability', $code)->first()->type === 'inherit')
                                <li>
                                    <span>{{ $name }}</span>
                                    <code>{{ $code }}</code>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --bg: #020617;
            --card: #0f172a;
            --border: #1e293b;
            --neon: #38bdf8;
        }

        /* Header */
        .header-dark {
            background: linear-gradient(145deg, #020617, #020617dd);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, .9);
        }

        /* Buttons */
        .btn-dark-outline {
            background: #020617;
            border: 1px solid var(--border);
            color: #cbd5f5;
            padding: 10px 18px;
            border-radius: 10px;
        }

        .btn-dark-outline:hover {
            background: #020617;
            box-shadow: 0 0 20px rgba(56, 189, 248, .4);
        }

        .btn-edit-role {
            background: linear-gradient(135deg, #f59e0b, #facc15);
            color: #000;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 0 20px rgba(250, 204, 21, .5);
        }

        .btn-edit-role:hover {
            transform: translateY(-2px);
        }

        /* Cards */
        .permission-card {
            background: var(--card);
            border-radius: 18px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, .9);
            overflow: hidden;
            height: 100%;
        }

        .permission-card .card-header {
            padding: 16px 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: .8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Headers Colors */
        .permission-card.allow .card-header {
            background: #022c22;
            color: #22c55e
        }

        .permission-card.deny .card-header {
            background: #450a0a;
            color: #ef4444
        }

        .permission-card.inherit .card-header {
            background: #1e293b;
            color: #94a3b8
        }

        /* List */
        .permission-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .permission-list li {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: .3s;
        }

        .permission-list li:hover {
            background: #020617;
            transform: translateX(6px);
        }

        .permission-list span {
            font-weight: 600;
            color: #e5e7eb;
        }

        .permission-list code {
            font-size: .7rem;
            background: #020617;
            padding: 3px 6px;
            border-radius: 6px;
            color: #94a3b8;
        }

        .permission-list .empty {
            color: #64748b;
            text-align: center;
            justify-content: center;
        }

        /* Sticky */
        .sticky-action-bar {
            position: sticky;
            top: 70px;
            z-index: 1020;
        }
    </style>
@endpush
