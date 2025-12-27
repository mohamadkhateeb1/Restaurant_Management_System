@extends('layouts.app')

@section('content')
<div class="container py-4 text-end" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 text-white mb-1"><i class="fas fa-utensils text-primary me-2"></i>إدارة المنيو والمخزن</h2>
            <p class="text-muted small">متابعة دقيقة للأصناف المعروضة وكمياتها المتوفرة لحظياً من المستودع</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('Pages.Items.create') }}" class="btn btn-primary d-flex align-items-center px-4 rounded-pill shadow">
                <i class="fas fa-plus me-2"></i> إضافة صنف بيع
            </a>
        </div>
    </div>

    {{-- الفلترة الذكية --}}
    <div class="card bg-dark border-0 mb-4 shadow-sm" style="border-radius: 15px; background-color: #1e1e1e !important;">
        <div class="card-body p-4">
            <form action="{{ route('Pages.Items.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-light small fw-bold">القسم البيعي</label>
                    <select name="category_id" class="form-select bg-dark text-white border-secondary rounded-3">
                        <option value="">كل الأقسام</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-light small fw-bold">حالة التوفر</label>
                    <select name="status" class="form-select bg-dark text-white border-secondary rounded-3">
                        <option value="">الكل</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>معروض</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>متوقف</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1 rounded-pill">تطبيق</button>
                    <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-secondary px-3 rounded-pill"><i class="fas fa-undo"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- الجدول --}}
    <div class="card bg-dark border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
        <div class="table-responsive">
            <x-flash_message />
            <table class="table table-dark table-hover mb-0 align-middle text-end">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th class="px-4 py-3">الصنف</th>
                        <th class="px-4 py-3">التصنيف</th>
                        <th class="px-4 py-3 text-center">المتوفر بالمخزن</th>
                        <th class="px-4 py-3">السعر</th>
                        <th class="px-4 py-3 text-center">الحالة</th>
                        <th class="px-4 py-3 text-start">إدارة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        {{-- الوصول للبيانات عبر علاقة الـ inventory بشكل آمن --}}
                        @php
                            $inventory = $item->inventory;
                            $currentStock = $inventory ? $inventory->quantity : 0;
                            $minStock = $inventory ? $inventory->min_quantity : 0;
                        @endphp
                        <tr class="border-bottom border-secondary transition-all">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/no-image.png') }}"
                                        class="rounded shadow-sm border border-secondary" style="width: 45px; height: 45px; object-fit: cover;">
                                    <span class="fw-bold">{{ $item->item_name }}</span>
                                </div>
                            </td>
                            <td class="px-4"><span class="badge bg-secondary bg-opacity-25 border border-secondary text-info">{{ $item->category->name }}</span></td>
                            <td class="px-4 text-center">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold {{ $currentStock <= $minStock ? 'text-danger' : 'text-info' }}">
                                        {{ number_format($currentStock, 0) }} {{ $inventory->unit ?? '' }}
                                    </span>
                                    @if($currentStock <= $minStock)
                                        <small class="text-danger animate-pulse" style="font-size: 10px;">نقص في المخزن!</small>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 text-success fw-bold">{{ number_format($item->price, 0) }} ل.س</td>
                            <td class="px-4 text-center">
                                {{-- الربط بين حالة العرض في المنيو وتوفر الكمية في المخزن --}}
                                @if ($item->status == 'available' && $currentStock > 0)
                                    <span class="badge rounded-pill bg-success-soft text-success border border-success px-2 py-1 small">جاهز للبيع</span>
                                @elseif($currentStock <= 0)
                                    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-2 py-1 small">نافذ</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-soft text-muted border border-secondary px-2 py-1 small">مخفي</span>
                                @endif
                            </td>
                            <td class="px-4 text-start">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('Pages.Items.edit', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('Pages.Items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('استمرار حذف الصنف من قائمة المنيو؟ (لن يتم حذفه من المستودع)')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">لا توجد أطباق مرتبطة بالمخزن حالياً</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .4; } }
</style>
@endsection