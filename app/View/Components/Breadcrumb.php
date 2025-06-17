<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.breadcrumb');
    }
} 