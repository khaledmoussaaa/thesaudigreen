<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderStatus extends Component
{
    public $status;
    public $icon;
    public $text;

    public function __construct($status = null, $icon, $text)
    {
        $this->status = $status;
        $this->icon = $icon;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.header-status');
    }
}
