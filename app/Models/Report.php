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
        'report_type',
        'title',
        'employee_id',
        'from_date',
        'to_date',
        'data_content',
        'total_summary',
        'file_path'
    ];


    protected $casts = [
        'data_content' => 'array',
        'from_date'    => 'date',
        'to_date'      => 'date',
        'total_summary' => 'decimal:2',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }


    public function scopeOfType($query, $type)
    {
        return $query->where('report_type', $type);
    }
}
