<div class="row g-3" dir="rtl">
    <div class="col-md-6 text-right">
        <label class="form-label fw-bold">نوع الحركة</label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="in" {{ old('type', $transaction->type ?? '') == 'in' ? 'selected' : '' }}>وارد (In)</option>
            <option value="out" {{ old('type', $transaction->type ?? '') == 'out' ? 'selected' : '' }}>صادر (Out)</option>
            <option value="adjustment" {{ old('type', $transaction->type ?? '') == 'adjustment' ? 'selected' : '' }}>تعديل (Adjustment)</option>
        </select>
        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 text-right">
        <label class="form-label fw-bold">الكمية</label>
        <x-form.input 
            type="number" 
            step="0.01" 
            name="quantity" 
            :value="old('quantity', $transaction->quantity ?? '')" 
            required 
        />
    </div>

    <div class="col-md-12 text-right">
        <label class="form-label fw-bold">المرجع (رقم الفاتورة)</label>
        <x-form.input 
            name="reference" 
            :value="old('reference', $transaction->reference ?? '')" 
            placeholder="مثال: فاتورة توريد رقم #456" 
        />
    </div>

    <div class="col-md-12 text-right">
        <label class="form-label fw-bold">ملاحظات</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $transaction->notes ?? '') }}</textarea>
    </div>
</div>