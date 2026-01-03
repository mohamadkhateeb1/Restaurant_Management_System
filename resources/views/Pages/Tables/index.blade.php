@extends('layouts.app')

@section('title', __('tables management'))

@section('content')
<div class="container-fluid py-4 text-white">

    {{-- ===== HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">
                <i class="fas fa-chair text-info me-2"></i>
                {{ __('tables management') }}
            </h2>
            <p class="text-muted small">
                {{ __('manage restaurant tables') }}
            </p>
        </div>

        <div class="d-flex gap-2">
            @if ($tables->count() > 0)
                <form action="{{ route('Pages.Tables.bulkDestroy') }}" method="POST"
                      onsubmit="return confirm('{{ __('confirm delete all tables') }}')">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="location" value="{{ request('location') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm">
                        <i class="fas fa-trash-sweep me-2"></i>
                        {{ __('delete all tables') }}
                    </button>
                </form>
            @endif

            <a href="{{ route('Pages.Tables.create') }}" class="btn btn-info px-4 fw-bold shadow-sm">
                <i class="fas fa-plus me-2"></i>
                {{ __('add new table') }}
            </a>
        </div>
    </div>

    <x-flash_message />

    {{-- ===== FILTERS ===== --}}
    <div class="card bg-dark border-0 shadow-lg mb-4" style="border-radius:12px;">
        <div class="card-body p-3">
            <form id="tableFilterForm" method="GET" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label text-info small fw-bold">
                        {{ __('location section') }}
                    </label>
                    <select name="location"
                            class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
                        <option value="">{{ __('all locations') }}</option>

                        @foreach ($locations ?? [] as $location)
                            <option value="{{ $location }}"
                                {{ request('location') == $location ? 'selected' : '' }}>
                                {{ __($location) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold">
                        {{ __('operational status') }}
                    </label>
                    <select name="status"
                            class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
                        <option value="">{{ __('all statuses') }}</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>
                            {{ __('available') }}
                        </option>
                        <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>
                            {{ __('occupied') }}
                        </option>
                        <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>
                            {{ __('reserved') }}
                        </option>
                    </select>
                </div>

                <div class="col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-info px-4 fw-bold flex-grow-1">
                        <i class="fas fa-filter me-2"></i>
                        {{ __('apply filters') }}
                    </button>
                    <button type="button" onclick="resetFilter()"
                            class="btn btn-outline-secondary px-4 shadow-none">
                        <i class="fas fa-undo"></i>
                        {{ __('reset filters') }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="card bg-dark border-0 shadow-lg" style="border-radius:12px;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="bg-secondary bg-opacity-10 text-info">
                    <tr>
                        <th class="ps-4 py-3">{{ __('table number') }}</th>
                        <th class="py-3 text-center">{{ __('seating capacity') }}</th>
                        <th class="py-3 text-center">{{ __('operational status') }}</th>
                        <th class="py-3">{{ __('date added') }}</th>
                        <th class="pe-4 py-3 text-end">{{ __('actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tables as $table)
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td class="ps-4 fw-bold fs-5 text-info">
                                {{ $table->table_number }}
                            </td>

                            <td class="text-center">
                                {{ $table->seating_capacity }} {{ __('seats') }}
                            </td>

                            <td class="text-center">
                                @if ($table->status === 'available')
                                    <span class="badge bg-success-soft text-success">
                                        <i class="fas fa-check me-1"></i>{{ __('available') }}
                                    </span>
                                @elseif ($table->status === 'occupied')
                                    <span class="badge bg-danger-soft text-danger">
                                        <i class="fas fa-utensils me-1"></i>{{ __('occupied') }}
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="fas fa-clock me-1"></i>{{ __('reserved') }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3">
                                {{ $table->created_at->format('Y-m-d') }}
                            </td>

                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('Pages.Tables.edit', $table->id) }}"
                                       class="btn btn-sm btn-outline-warning border-0">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('Pages.Tables.destroy', $table->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('{{ __('confirm delete table') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger border-0">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                                <p class="text-muted">
                                    {{ __('no results found') }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $tables->appends(request()->query())->links() }}
    </div>

</div>

{{-- ===== STYLES ===== --}}
<style>
    .bg-success-soft { background-color: rgba(25,135,84,.1); }
    .bg-danger-soft  { background-color: rgba(220,53,69,.1); }
    .table td { border-bottom-width: 0; }
    .btn-group .btn:hover { background: rgba(255,255,255,.05); }
    .form-select option { background:#212529; color:#fff; }
</style>

{{-- ===== JS ===== --}}
 <script>
        function resetFilter() {
            const form = document.getElementById('tableFilterForm');
            if (form) {
                form.querySelector('select[name="location"]').value = "";
                form.querySelector('select[name="status"]').value = "";
                form.submit();
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.transition = "opacity 0.6s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 600);
                });
            }, 2000);
        });
    </script>
@endsection



  