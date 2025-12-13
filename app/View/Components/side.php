<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class side extends Component
{
    public $sideItems;
    public function __construct()
    {
        $this->sideItems = config('side');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side');
    }
}
