<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'report_type',    // نوع التقرير (sales, inventory, employees, kitchen, tables)
        'title',          // عنوان التقرير
        'employee_id',    // الموظف الذي استخرج التقرير
        'from_date',      // تاريخ بداية التقرير
        'to_date',        // تاريخ نهاية التقرير
        'data_content',   // البيانات التقنية (JSON)
        'total_summary',  // الإجمالي المالي أو الرقمي
        'file_path'       // مسار ملف PDF إن وجد
    ];

    /**
     * تحويل الحقول تلقائياً عند الجلب أو الحفظ
     */
    protected $casts = [
        'data_content' => 'array',    // لتحويل الـ JSON إلى مصفوفة PHP تلقائياً والعكس
        'from_date'    => 'date',
        'to_date'      => 'date',
        'total_summary' => 'decimal:2',
    ];

    /**
     * علاقة التقرير بالموظف الذي قام بإنشائه
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * "Scope" للبحث السريع عن تقارير معينة (مثلاً المبيعات فقط)
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('report_type', $type);
    }
}