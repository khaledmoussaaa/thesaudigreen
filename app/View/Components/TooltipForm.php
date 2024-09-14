<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TooltipForm extends Component
{
    public $route;
    public $name;
    public $class;
    public $uid;
    public $rid;
    public $icon;
    public $text;

    public function __construct($route, $name, $class, $uid = null, $rid = null, $icon, $text)
    {
        $this->route = $route;
        $this->name = $name;
        $this->class = $class;
        $this->uid = $uid;
        $this->rid = $rid;
        $this->icon = $icon;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.tooltip-form');
    }
}
