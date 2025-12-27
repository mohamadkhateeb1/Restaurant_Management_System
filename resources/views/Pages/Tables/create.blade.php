@extends('layouts.app')

@section('title', 'إضافة طاولة جديدة')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="d-flex justify-content-between align-items-center mb-4 text-white">
                    <h2 class="h3 mb-0">
                        <i class="fas fa-plus-circle text-info me-2"></i>@lang('Add New Table')
                    </h2>
                    <a href="{{ route('Pages.Tables.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-right me-2"></i> @lang('Back to List')
                    </a>
                </div>

                <div class="card bg-dark border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-header bg-info py-3">
                        <h5 class="card-title mb-0 text-white fw-bold">@lang('Basic Table Information')</h5>
                    </div>

                    <div class="card-body p-4 text-white">
                        <form method="POST" action="{{ route('Pages.Tables.store') }}">
                            @csrf

                            @include('Pages.Tables._form') 

                            <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top border-secondary">
                                <button type="reset" class="btn btn-outline-secondary px-4">@lang('Reset')</button>
                                <button type="submit" class="btn btn-info px-5 fw-bold shadow">@lang('Save Table')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
