<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusIndicator extends Component
{
    public string $status;
    public string $variant;

    public function __construct(string $status, string $variant = 'solid')
    {
        $this->status = strtolower($status);
        $this->variant = strtolower($variant);
    }

    public function render(): View|Closure|string
    {
        return view('components.status-indicator', [
            'status' => $this->status,
            'variant' => $this->variant,
        ]);
    }
}
