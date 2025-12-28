@extends('Layouts.app')
@section('title', 'Roles Management')

@section('content')
    <div class="container-fluid py-4">
        <div class="sticky-action-bar mb-4">
            <div
                class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center bg-white p-3 rounded-lg border shadow-sm gap-3">
                <div>
                    <h4 class="mb-0 font-weight-bold text-dark d-flex align-items-center">
                        <i class="fas fa-user-shield text-primary mr-2"></i>
                        <span class="text-truncate">@lang('Roles Management')</span>
                    </h4>
                    <p class="text-muted small mb-0 d-none d-md-block">@lang('Manage system roles and permissions')</p>
                </div>
                @can('create', App\Models\Role::class)
                    <a href="{{ route('Pages.roles.create') }}"
                        class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm border-0 btn-modern w-100 w-sm-auto">
                        <i class="fas fa-plus-circle mr-1"></i> @lang('Create New Role')
                    </a>
                @endcan
            </div>
        </div>

        <x-flash_message />

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-xl overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 custom-admin-table custom-responsive-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 border-0 text-secondary small text-uppercase d-none d-sm-table-cell"
                                            style="width: 100px;">@lang('ID')</th>
                                        <th class="py-3 border-0 text-secondary small text-uppercase">@lang('Role Name')</th>
                                        <th class="py-3 border-0 text-secondary small text-uppercase text-center"
                                            style="width: 200px;">@lang('Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr class="table-row-fade">
                                            <td class="px-4 py-4 d-none d-sm-table-cell">
                                                <span class="font-weight-bold text-muted">#{{ $role->id }}</span>
                                            </td>
                                            <td class="py-4 font-weight-bold text-dark h6 mb-0">
                                                <div class="d-flex flex-column">
                                                    <span>{{ $role->name }}</span>
                                                    <small class="text-muted d-sm-none mt-1">
                                                        {{ $role->id }}</small>
                                                </div>
                                            </td>
                                            <td class="py-4 text-center">
                                                <div class="d-flex justify-content-center gap-1 gap-md-2">
                                                    <a href="{{ route('Pages.roles.show', $role->id) }}"
                                                        class="btn-action btn-show" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @can('update', App\Models\Role::class)
                                                        <a href="{{ route('Pages.roles.edit', $role->id) }}"
                                                            class="btn-action btn-edit" title="Edit">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete', App\Models\Role::class)
                                                        <form action="{{ route('Pages.roles.destroy', $role->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-action btn-delete"
                                                                onclick="return confirm('Are you sure?')" title="Delete">
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

        .rounded-xl {
            border-radius: 12px !important;
        }

        .custom-admin-table tbody tr {
            transition: background-color 0.15s ease-in-out;
        }

        .custom-admin-table tbody tr:hover {
            background-color: #fbfcfe !important;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            text-decoration: none !important;
        }

        .btn-show {
            background-color: #f0f7ff;
            color: #007bff;
        }

        .btn-show:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn-edit {
            background-color: #fff9e6;
            color: #ffc107;
        }

        .btn-edit:hover {
            background-color: #ffc107;
            color: #fff;
        }

        .btn-delete {
            background-color: #fff5f5;
            color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #dc3545;
            color: #fff;
        }

        @media (max-width: 576px) {
            .sticky-action-bar {
                position: static;
            }


            .btn-action {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }

            .custom-admin-table td {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            h4 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .w-sm-auto {
            @media (min-width: 576px) {
                width: auto !important;
            }
        }
    </style>
@endpush
