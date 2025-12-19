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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif
                <form action="{{ route('Pages.admin.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('Pages.Admin._form')
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
