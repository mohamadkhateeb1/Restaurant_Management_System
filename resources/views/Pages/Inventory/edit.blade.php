@extends('layouts.app')
@section('content')
    <div class="container py-5" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden animate-slide-up" style="background: #0d0f11;">
                    <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(135deg, #16191c 0%, #000000 100%); border-bottom: 1px solid rgba(255,255,255,0.05) !important;">
                        <div>
                            <h4 class="mb-1 fw-bold text-white fs-5">
                                <i class="fas fa-edit text-warning me-2"></i> @lang('Edit Inventory Item')
                            </h4>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <span class="sku-tag-dark">REF: {{ $item->sku }}</span>
                                @if ($item->item_type == 'menu_item')
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3">
                                        <i class="fas fa-utensils me-1"></i>@lang('Menu Item')
                                    </span>
                                @else
                                    <span
                                        class="badge bg-secondary bg-opacity-10 text-muted border border-secondary border-opacity-25 rounded-pill px-3">
                                        <i class="fas fa-seedling me-1"></i> @lang('Internal Raw Material')
                                    </span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('Pages.inventory.index') }}" class="btn-close-premium transition-all">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if ($item->item_type == 'menu_item')
                            <div class="alert alert-sync-warning border-0 rounded-4 shadow-sm mb-5 d-flex align-items-center"
                                role="alert">
                                <i class="fas fa-sync-alt fa-spin me-3 fs-4 text-warning"></i>
                                <div class="small fw-600">
                                    <strong class="text-warning d-block mb-1">@lang('Immediate synchronization notice')</strong>
                                    @lang('This item is a menu item. Any changes to the name, quantity, or category will be automatically updated in the menu to ensure data consistency.')
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('Pages.inventory.update', $item->id) }}" method="POST"
                            enctype="multipart/form-data" class="premium-form">
                            @csrf
                            @method('PUT')
                            <div class="form-section-wrapper">
                                <div class="section-header-tag mb-4">
                                    <i class="fas fa-sliders-h me-2"></i> @lang('Inventory Item Details')
                                </div>
                                <div class="section-content-box p-4 rounded-4 shadow-inner">
                                    @include('Pages.Inventory._form')
                                </div>
                            </div>

                            <div
                                class="form-footer-actions mt-5 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center border-top border-white border-opacity-10">
                                <div class="text-muted small mb-3 mb-md-0 fw-600">
                                    <i class="fas fa-history me-1 text-info"></i> آخر تحديث:
                                    {{ $item->updated_at->diffForHumans() }}
                                </div>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('Pages.inventory.index') }}"
                                        class="btn btn-dark-minimal rounded-pill px-5 py-3 fw-bold">
                                        إلغاء
                                    </a>
                                    <button type="submit"
                                        class="btn btn-warning-neon rounded-pill px-5 py-3 fw-bold shadow-glow transition-up text-black">
                                        <i class="fas fa-save me-2"></i> حفظ التعديلات والمزامنة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');

        body {
            background-color: #08090a;
            font-family: 'Cairo', sans-serif;
            color: #e1e1e1;
        }

        .shadow-2xl {
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.9);
        }

        .shadow-inner {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .sku-tag-dark {
            background: #000;
            color: #58a6ff;
            font-family: monospace;
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 6px;
            border: 1px solid rgba(88, 166, 255, 0.2);
        }

        .btn-close-premium {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .btn-close-premium:hover {
            background: #ff3e3e;
            color: white;
            transform: rotate(90deg);
            box-shadow: 0 0 15px rgba(255, 62, 62, 0.4);
        }

        .alert-sync-warning {
            background: rgba(210, 153, 34, 0.08);
            color: #8b949e;
            border: 1px solid rgba(210, 153, 34, 0.2);
            border-right: 5px solid #d29922;
        }

        .section-header-tag {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(210, 153, 34, 0.05);
            color: #d29922;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            border: 1px solid rgba(210, 153, 34, 0.1);
        }

        .btn-warning-neon {
            background: #f59e0b;
            border: none;
            transition: 0.4s;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);
        }

        .btn-warning-neon:hover {
            background: #fff;
            transform: translateY(-4px);
            box-shadow: 0 0 30px #f59e0b;
        }

        .btn-dark-minimal {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #888;
            transition: 0.3s;
        }

        .btn-dark-minimal:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-color: #fff;
        }

        .premium-form .form-control-dark,
        .premium-form .form-select-dark {
            background-color: #1a1d21 !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            color: #fff !important;
            border-radius: 12px;
            padding: 14px;
        }

        .animate-slide-up {
            animation: slideUp 0.8s cubic-bezier(0.2, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .premium-form div[class*="border-primary"][class*="bg-primary"] {
            display: none !important;
        }
    </style>
@endsection
