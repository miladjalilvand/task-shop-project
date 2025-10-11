<?php

namespace Modules\Carts\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CartButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('carts::components.cartbutton');
    }
}
