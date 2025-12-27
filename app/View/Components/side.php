<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class side extends Component
{
    public $sideItems;

    public function __construct()
    {
        $this->sideItems = $this->prepareItems(config('side'));
    }

    protected function prepareItems($items)
    {
        /** @var \App\Models\Employee $user */
        // جلب الموظف المسجل دخوله حالياً
        $user = Auth::guard('employee')->user();
        
        if (!$user) return [];

        return array_filter($items, function ($item) use ($user) {
            // إذا لم تكن هناك صلاحية مطلوبة (مثل Dashboard)، يظهر العنصر
            if (!isset($item['ability']) || $item['ability'] === null) {
                return true;
            }

            // لارافل سيتوجه تلقائياً للـ Policy الصحيحة بناءً على الـ Model الممرر
            return $user->can($item['ability'], $item['model'] ?? null);
        });
    }

    public function render()
    {
        return view('components.side');
    }
}