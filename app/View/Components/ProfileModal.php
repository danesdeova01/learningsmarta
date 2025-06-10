<?php

namespace App\View\Components;

use App\Models\Peneliti;
use Illuminate\View\Component;

class ProfileModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.profile-modal', [
            'data' => Peneliti::find('17802241006'),
        ]);
    }
}
