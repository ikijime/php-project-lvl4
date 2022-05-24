<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertUnableDelete extends Component
{
    public mixed $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(mixed $message)
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert-unable-delete');
    }
}
