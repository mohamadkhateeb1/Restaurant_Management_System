@extends('Layouts.app')
@section('title', 'تفاصيل صلاحيات الدور')

@section('content')
    <div class="container-fluid py-4">
        <div class="sticky-action-bar mb-4">
            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border shadow-sm">
                <div>
                    <h4 class="mb-0 font-weight-bold text-dark">
                        <i class="fas fa-shield-alt text-primary mr-2"></i> صلاحيات الدور: {{ $role->name }}
                    </h4>
                    <p class="text-muted small mb-0">عرض مصفوفة الوصول الفعلي لهذا الدور في النظام</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('Pages.roles.index') }}" class="btn btn-light border px-4 font-weight-bold mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> العودة للقائمة
                    </a>
                    @can('update', App\Models\Role::class)
                        <a href="{{ route('Pages.roles.edit', $role->id) }}"
                            class="btn btn-warning px-4 font-weight-bold text-dark">
                            <i class="fas fa-edit mr-1"></i> تعديل الصلاحيات
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white font-weight-bold py-3">
                        <i class="fas fa-check-circle mr-2"></i> الصلاحيات المسموحة (Allow)
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($role->abilities->where('type', 'allow') as $ability)
                                <li class="list-group-item py-3">
                                    <div class="font-weight-bold text-dark">{{ $ability->ability }}</div>
                                    <code class="text-muted small">{{ $ability->ability }}</code>
                                </li>
                            @empty
                                <li class="list-group-item text-muted text-center py-4">لا توجد صلاحيات مسموحة</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-danger text-white font-weight-bold py-3">
                        <i class="fas fa-times-circle mr-2"></i> الصلاحيات المرفوضة (Deny)
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($role->abilities->where('type', 'deny') as $ability)
                                <li class="list-group-item py-3">
                                    <div class="font-weight-bold text-dark">{{ $ability->ability }}</div>
                                    <code class="text-muted small">{{ $ability->ability }}</code>
                                </li>
                            @empty
                                <li class="list-group-item text-muted text-center py-4">لا توجد صلاحيات مرفوضة</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-secondary text-white font-weight-bold py-3">
                        <i class="fas fa-minus-circle mr-2"></i> الصلاحيات الافتراضية (Inherit)
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach (config('abilities') as $ability_code => $ability_name)
                                @if (
                                    !$role->abilities->where('ability', $ability_code)->first() ||
                                        $role->abilities->where('ability', $ability_code)->first()->type === 'inherit')
                                    <li class="list-group-item py-3">
                                        <div class="font-weight-bold text-dark">{{ $ability_name }}</div>
                                        <code class="text-muted small">{{ $ability_code }}</code>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .sticky-action-bar {
            position: sticky;
            top: 70px;
            z-index: 1020;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
        }

        .list-group-item {
            border-left: 0;
            border-right: 0;
            transition: background 0.2s;
        }

        .list-group-item:hover {
            background-color: #fcfcfc;
        }

        .gap-2 {
            gap: 10px;
        }
    </style>
@endpush
