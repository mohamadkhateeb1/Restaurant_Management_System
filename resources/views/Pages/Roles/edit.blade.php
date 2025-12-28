@extends('Layouts.app')

@section('title', 'Edit Role: ' . $role->name)

@section('content')
    <form action="{{ route('Pages.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container-fluid py-4">
            <div class="sticky-action-bar shadow-sm mb-4 animate__animated animate__fadeInDown">
                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-lg border">
                    <div>
                        <h4 class="mb-0 font-weight-bold text-dark">
                            <i class="fas fa-user-edit text-warning mr-2"></i> Update Role Entity
                        </h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 m-0 small">
                                <li class="breadcrumb-item"><a href="{{ route('Pages.roles.index') }}">Roles Management</a>
                                </li>
                                <li class="breadcrumb-item active text-muted">Editing: {{ $role->name }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('Pages.roles.index') }}"
                            class="btn btn-light border px-4 py-2 font-weight-bold mr-2 transition-all">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        <button type="submit"
                            class="btn btn-warning text-dark px-5 py-2 font-weight-bold shadow-sm transition-all btn-glow-warning">
                            <i class="fas fa-sync-alt mr-1"></i> Update & Sync Changes
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-11 mx-auto">

                    @if ($errors->any())
                        <div class="alert alert-custom-danger shadow-sm border-0 mb-4 animate__animated animate__shakeX">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle mr-3 fa-lg"></i>
                                <div>
                                    <h5 class="mb-1 font-weight-bold">Update Failed!</h5>
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card shadow-lg border-0 rounded-xl overflow-hidden">
                        <div class="card-header border-0 py-4 bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold text-muted text-uppercase small" style="letter-spacing: 2px;">
                                <span class="badge badge-warning-soft mr-2">Mode: Edit</span>
                                Modification of Permissions Matrix
                            </h5>
                            <div class="small text-muted italic">
                                System ID: <span class="font-weight-bold text-dark">#{{ $role->id }}</span>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @include('Pages.Roles._form')
                        </div>

                        <div class="card-footer bg-white py-4 border-0 text-center text-muted small border-top">
                            Note: Updating this role will immediately affect all employees assigned to it.
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
        .sticky-action-bar {
            position: sticky;
            top: 70px;
            z-index: 1020;
            margin-top: -10px;
        }

        .rounded-xl {
            border-radius: 1.25rem !important;
        }

        .badge-warning-soft {
            background-color: #fff9e6;
            color: #d39e00;
        }

        .transition-all {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .transition-all:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-glow-warning:hover {
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.4) !important;
        }

        .alert-custom-danger {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 5px solid #fc8181;
            border-radius: 12px;
        }

        .gap-2 {
            gap: 0.75rem;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            border: none;
            border-radius: 8px;
        }

        .btn-light {
            background: #fff;
            border-radius: 8px;
        }

        .card {
            border-radius: 1.25rem !important;
        }

        body {
            background-color: #f8f9fc;
        }

        .italic {
            font-style: italic;
        }
    </style>
@endpush
