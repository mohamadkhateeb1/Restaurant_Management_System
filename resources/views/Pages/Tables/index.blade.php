@extends('layouts.app')
@section('title', 'إدارة الطاولات')
@section('content')
    <div class="container-fluid py-4 text-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-0"><i class="fas fa-chair text-info me-2"></i>@lang('Tables Management')</h2>
                <p class="text-muted small">@lang('Manage the restaurant tables')</p>
            </div>
            <div class="d-flex gap-2">
                @if ($tables->count() > 0)
                    <form action="{{ route('Pages.Tables.bulkDestroy') }}" method="POST"
                        onsubmit="return confirm('تحذير: هل أنت متأكد من حذف جميع الطاولات المعروضة؟ لا يمكن التراجع عن هذا الإجراء.')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="location" value="{{ request('location') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <button type="submit" class="btn btn-outline-danger px-4 fw-bold shadow-sm">
                            <i class="fas fa-trash-sweep me-2"></i>@lang('Delete All Displayed Tables')
                        </button>
                    </form>
                @endif
                <a href="{{ route('Pages.Tables.create') }}" class="btn btn-info px-4 fw-bold shadow-sm">
                    <i class="fas fa-plus me-2"></i> @lang('Add New Table')
                </a>
            </div>
        </div>

        <x-flash_message />

        <div class="card bg-dark border-0 shadow-lg mb-4" style="border-radius: 12px;">
            <div class="card-body p-3">
                <form id="tableFilterForm" action="{{ route('Pages.Tables.index') }}" method="GET"
                    class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-info small fw-bold">@lang('Location / Section')</label>
                        <select name="location"
                            class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
                            <option value="">@lang('All Locations')</option>
                            <option value="الصالة الرئيسية"
                                {{ request('location') == 'الصالة الرئيسية' ? 'selected' : '' }}>@lang('Main Hall')</option>
                            <option value="التراس الخارجي" {{ request('location') == 'التراس الخارجي' ? 'selected' : '' }}>
                                @lang('External Terrace')</option>
                            <option value="قسم العائلات" {{ request('location') == 'قسم العائلات' ? 'selected' : '' }}>
                                @lang('Family Section')</option>
                            <option value="قسم الـ VIP" {{ request('location') == 'قسم الـ VIP' ? 'selected' : '' }}>
                                @lang('VIP Section')
                                VIP</option>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <label class="form-label text-info small fw-bold">@lang('Operational Status')</label>
                        <select name="status"
                            class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
                            <option value="">@lang('All Statuses')</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>
                                @lang('Available')
                            </option>
                            <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>
                                @lang('Occupied')
                            </option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>
                                @lang('Reserved')
                            </option>
                        </select>
                    </div>

                    <div class="col-md-5 d-flex gap-2">
                        <button type="submit" class="btn btn-info px-4 fw-bold flex-grow-1">
                            <i class="fas fa-filter me-2"></i> @lang('Apply Filters')
                        </button>
                        <button type="button" onclick="resetFilter()" class="btn btn-outline-secondary px-4 shadow-none">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card bg-dark border-0 shadow-lg" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="bg-secondary bg-opacity-10 text-info">
                            <tr>
                                <th class="ps-4 py-3">@lang('Table Number')</th>
                                <th class="py-3">@lang('Location / Section')</th>
                                <th class="py-3 text-center">@lang('Seating Capacity')</th>
                                <th class="py-3 text-center">@lang('Operational Status')</th>
                                <th class="py-3">@lang('Date Added')</th>
                                <th class="pe-4 py-3 text-end">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tables as $table)
                                <tr class="border-bottom border-secondary border-opacity-25">
                                    <td class="ps-4 fw-bold fs-5 text-info">{{ $table->table_number }}</td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-50 text-light px-3 py-2">
                                            <i class="fas fa-map-marker-alt me-1 text-info"></i>
                                            {{ $table->location ?? 'غير محدد' }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $table->seating_capacity }} @lang('Seats')</td>
                                    <td class="text-center">
                                        @if ($table->status == 'available')
                                            <span class="badge bg-success-soft text-success"><i
                                                    class="fas fa-check me-1"></i> @lang('Available')</span>
                                        @elseif($table->status == 'occupied')
                                            <span class="badge bg-danger-soft text-danger"><i
                                                    class="fas fa-utensils me-1"></i> @lang('Occupied')</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning"><i
                                                    class="fas fa-clock me-1"></i> @lang('Reserved')</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $table->created_at->format('Y-m-d') }}</td>
                                    <td class="pe-4 text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('Pages.Tables.edit', $table->id) }}"
                                                class="btn btn-sm btn-outline-warning border-0">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('Pages.Tables.destroy', $table->id) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذه الطاولة؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
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
                                        <p class="text-muted">@lang('No results match the current filter options')</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $tables->appends(request()->query())->links() }}
        </div>
    </div>

    <style>
        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .table td {
            border-bottom-width: 0;
        }

        .btn-group .btn:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .form-select option {
            background-color: #212529;
            color: white;
        }
    </style>

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
