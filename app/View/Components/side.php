<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;

class side extends Component
{
    public $sideItems;

    public function __construct()
    {
        $this->sideItems = $this->prepareItems(config('side'));
    }


    public function render(): View|Closure|string
    {
        return view('components.side');
    }


    protected function prepareItems($items)
    {
        return array_filter($items, function ($item) {
            if (!isset($item['gate']) || is_null($item['gate'])) {
                return true;
            }

            return Gate::allows($item['gate']);
        });
    }
}
