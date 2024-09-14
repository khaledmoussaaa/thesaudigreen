<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TooltipButton extends Component
{
    public $type;
    public $class;
    public $name;
    public $click;
    public $icon;
    public $text;
    public $confirm;

    public function __construct($type, $class, $name, $click, $icon = null, $text, $confirm = null)
    {
        $this->type = $type;
        $this->class = $class;
        $this->name = $name;
        $this->click = $click;
        $this->icon = $icon;
        $this->text = $text;
        $this->confirm = $confirm;
    }

    public function render()
    {
        return view('components.tooltip-button');
    }
}
