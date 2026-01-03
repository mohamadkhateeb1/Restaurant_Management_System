@extends('Layouts.app')

@section('title', 'Edit Role: ' . $role->name)

@section('content')
    <form action="{{ route('Pages.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container-fluid py-4">

            {{-- HEADER --}}
            <div class="sticky-action-bar mb-4">
                <div class="edit-header-dark d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="mb-1 fw-bold text-light">
                            <i class="fas fa-user-edit text-warning me-2"></i>
                            @lang('Edit Role')
                        </h4>
                        <small class="text-muted">
                            Editing permissions for: <b class="text-light">{{ $role->name }}</b>
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('Pages.roles.index') }}" class="btn btn-back-dark">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <button type="submit" class="btn btn-save-dark">
                            <i class="fas fa-sync-alt me-1"></i> Update Role
                        </button>
                    </div>
                </div>
            </div>

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0 rounded-3">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- CARD --}}
            <div class="card edit-card-dark border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    @include('Pages.Roles._form')
                </div>
                <div class="card-footer text-center text-muted small">
                    Updating this role affects all assigned users immediately
                </div>
            </div>

        </div>
    </form>
@endsection

@push('styles')
    <style>
        /* ===== Header ===== */
        .edit-header-dark {
            background: linear-gradient(145deg, #020617, #020617dd);
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, .9);
        }

        /* ===== Buttons ===== */
        .btn-back-dark {
            background: #020617;
            color: #94a3b8;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 10px 18px;
            transition: .3s;
        }

        .btn-back-dark:hover {
            color: #fff;
            box-shadow: 0 0 20px rgba(148, 163, 184, .3);
        }

        .btn-save-dark {
            background: linear-gradient(135deg, #facc15, #f59e0b);
            color: #000;
            border-radius: 10px;
            padding: 10px 26px;
            font-weight: 700;
            box-shadow: 0 0 25px rgba(250, 204, 21, .6);
        }

        .btn-save-dark:hover {
            box-shadow: 0 0 40px rgba(250, 204, 21, .9);
        }

        /* ===== Card ===== */
        .edit-card-dark {
            background: #020617;
            box-shadow: 0 40px 90px rgba(0, 0, 0, .9);
        }

        /* Sticky */
        .sticky-action-bar {
            position: sticky;
            top: 70px;
            z-index: 1020;
        }
    </style>
@endpush
