@extends('layouts.app') {{-- أو أي قالب أساسي تستخدمه --}}

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>إضافة صنف جديد</h4>
        </div>
        {{-- @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="card-body">
            {{-- تأكد من وجود enctype للسماح برفع الصور --}}
            <form method="POST" action="{{ route('Pages.categories.store') }}" enctype="multipart/form-data">
                @csrf

               @include('Pages.Categories._form')
                <button type="submit" class="btn btn-success">حفظ التصنيف</button>
                <a href="{{ route('Pages.categories.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection