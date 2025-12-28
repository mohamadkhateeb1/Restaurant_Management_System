<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
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
        
        $user = Auth::user();
        foreach ($items as $key => $item) {
            if(isset($item['ability']) && !$user->can($item['ability'] , isset($item['model']) ? $item['model'] : null)) {
                unset($items[$key]); 
            }           
        }
        return $items;
    }
}
