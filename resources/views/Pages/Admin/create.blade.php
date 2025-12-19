@extends('layouts.app')

@section('title', 'Create Role')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Create <small>Form</small></h3>
                </div>
                <form action="{{ route('Pages.admin.store') }}" method="POST">
                    @csrf
                    @include('Pages.Admin._form')
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('Pages.admin.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    @endsection
    @push('styles')
        <style>
            .alert {
                margin-top: 10px
            }
        </style>
    @endpush
    @push('stripts')
    @endpush
