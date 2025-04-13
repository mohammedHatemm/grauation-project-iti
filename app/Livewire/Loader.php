<?php

namespace App\Livewire;

use Livewire\Component;

class Loader extends Component
{
    // public function mount()
    // {
    //     $this->js('setTimeout(() => window.dispatchEvent(new Event("hideLoader")), 10000)');
    // }

    public function render()
    {
        return view('livewire.loader');
    }
}
