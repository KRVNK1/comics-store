<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartIndicator extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $count = auth()->check() ? auth()->user()->cartItems()->count() : 0;
        return view('components.cart-indicator', ['count' => $count]);
    }
}
