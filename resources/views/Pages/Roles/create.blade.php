@extends('Layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- عرض الأخطاء العامة إن وجدت --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Role <small>Form</small></h3>
                </div>

                <form action="{{ route('Pages.roles.store') }}" method="POST">
                    @csrf
                    
                    {{-- استدعاء ملف الحقول المشترك --}}
                    @include('Pages.Roles._form')

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Role
                        </button>
                        <a href="{{ route('Pages.roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .alert {
        margin-top: 10px;
    }
    /* تنسيق إضافي لجدول الصلاحيات داخل الـ card */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.02);
    }
</style>
@endpush

@push('scripts')
<script>
    // أي سكربتات إضافية تحتاجها (مثل اختيار الكل)
</script>
@endpush