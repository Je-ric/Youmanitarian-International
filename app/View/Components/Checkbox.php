<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $checked;

    public function __construct($checked = false)
    {
        $this->checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    }

    public function render()
    {
        return view('components.checkbox');
    }
} 