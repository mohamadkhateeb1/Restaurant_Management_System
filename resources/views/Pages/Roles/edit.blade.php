@extends('layouts.app')

@section('title', 'Edit Role') {{-- تعديل العنوان --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    {{-- تعديل المسمى --}}
                    <h3 class="card-title"> Edit Role: <small>{{ $role->name }}</small></h3>
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

                <form action="{{ route('Pages.roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- تمرير البيانات للملف المشترك لضمان استقرار العرض --}}
                    @include('Pages.Roles._form')

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Role</button>
                        <a href="{{ route('Pages.roles.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .alert {
            margin-top: 10px
        }
    </style>
@endpush

@push('scripts') {{-- تصحيح كلمة scripts --}}
@endpush