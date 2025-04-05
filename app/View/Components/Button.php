<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $variant;

    public function __construct($variant = 'primary')
    {
        $this->variant = $variant;
    }

    public function render()
    {
        return view('components.button');
    }
}
