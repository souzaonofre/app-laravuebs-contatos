<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    
    /**
     * contatos list
     *
     * @var Collection
     */
    public $contatos;

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  Collection  $contatos
     * @return void
     */
    public function __construct(Collection $contatos)
    {
        $this->contatos = $contatos;
    }
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
        return view('components.data-table');
    }
}
