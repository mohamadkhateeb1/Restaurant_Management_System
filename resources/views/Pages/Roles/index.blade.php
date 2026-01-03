@extends('Layouts.app')
@section('title', 'Roles Management')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="sticky-action-bar mb-4">
        <div class="header-dark d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <div>
                <h4 class="mb-1 fw-bold text-light d-flex align-items-center">
                    <i class="fas fa-user-shield text-neon me-2"></i>
                    <span>@lang('Roles Management')</span>
                </h4>
                <p class="mb-1 fw-bold text-light d-flex align-items-center ">
                    @lang('Manage system roles and permissions')
                </p>
            </div>

            @can('create', App\Models\Role::class)
                <a href="{{ route('Pages.roles.create') }}" class="btn btn-add-role px-4 py-2 fw-bold">
                    <i class="fas fa-plus-circle me-1"></i>
                    @lang('Create New Role')
                </a>
            @endcan
        </div>
    </div>

    <x-flash_message />

    {{-- TABLE --}}
    <div class="card table-card-dark rounded-xl overflow-hidden border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-admin-table-dark">
                <thead>
                    <tr>
                        <th class="fw-bold text-light">ID</th>
                        <th class="fw-bold text-light">ROLE NAME</th>
                        <th class="fw-bold text-light">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr class="table-row-dark">
                            <td class="d-none d-sm-table-cell text-muted fw-bold">
                                #{{ $role->id }}
                            </td>
                            <td class="fw-bold text-light">
                                {{ $role->name }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('Pages.roles.show', $role->id) }}"
                                       class="btn-action btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @can('update', App\Models\Role::class)
                                        <a href="{{ route('Pages.roles.edit', $role->id) }}"
                                           class="btn-action btn-edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endcan

                                    @can('delete', App\Models\Role::class)
                                        <form action="{{ route('Pages.roles.destroy', $role->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn-action btn-delete"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@push('styles')

<style>
    /* ===== Colors ===== */
:root{
    --dark-bg:#020617;
    --dark-card:#0f172a;
    --dark-row:#020617;
    --dark-border:#1e293b;
    --neon:#38bdf8;
}

/* ===== Header ===== */
.header-dark{
    background:linear-gradient(145deg,#020617,#020617cc);
    border-radius:16px;
    padding:20px;
    box-shadow:0 25px 60px rgba(0,0,0,.8);
}

/* ===== Add Button ===== */
.btn-add-role{
    background:linear-gradient(135deg,#2563eb,#38bdf8);
    color:#000;
    border-radius:12px;
    box-shadow:0 0 25px rgba(56,189,248,.6);
    transition:.3s;
}
.btn-add-role:hover{
    transform:translateY(-2px);
    box-shadow:0 0 40px rgba(56,189,248,.9);
}

/* ===== Table Card ===== */
.table-card-dark{
    background:var(--dark-card);
    box-shadow:0 40px 90px rgba(0,0,0,.9);
}

/* ===== Table ===== */
.custom-admin-table-dark thead{
    background:#020617;
    color:#64748b;
    text-transform:uppercase;
    font-size:.75rem;
}
.custom-admin-table-dark th{
    padding:16px 20px;
    border:none;
}
.custom-admin-table-dark td{
    padding:18px 20px;
    border-top:1px solid var(--dark-border);
}

/* ===== Rows ===== */
.table-row-dark{
    background:var(--dark-row);
    transition:.35s ease;
}
.table-row-dark:hover{
    background:#020617;
    box-shadow:inset 6px 0 0 var(--neon);
    transform:scale(1.01);
}

/* ===== Buttons ===== */
.btn-action{
    width:38px;
    height:38px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:none;
    transition:.3s;
    color:#fff;
}

.btn-view{
    background:#1e40af;
}
.btn-view:hover{
    box-shadow:0 0 20px #1e40af;
}

.btn-edit{
    background:#78350f;
}
.btn-edit:hover{
    box-shadow:0 0 20px #f59e0b;
}

.btn-delete{
    background:#7f1d1d;
}
.btn-delete:hover{
    box-shadow:0 0 20px #dc2626;
}

/* ===== Sticky ===== */
.sticky-action-bar{
    position:sticky;
    top:70px;
    z-index:1020;
}
/* FORCE DARK TABLE */
.custom-admin-table-dark,
.custom-admin-table-dark thead,
.custom-admin-table-dark tbody,
.custom-admin-table-dark tr,
.custom-admin-table-dark td,
.custom-admin-table-dark th {
    background-color: transparent !important;
}

.custom-admin-table-dark tbody tr {
    background: #020617 !important;
}

.custom-admin-table-dark tbody tr:hover {
    background: #020617 !important;
}

</style>
@endpush
@endsection
