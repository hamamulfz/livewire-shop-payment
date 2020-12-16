<?php

namespace App\Http\Livewire\Product;


use App\Product;
use Livewire\Component;
use Livewire\HydrationMiddleware\UpdateQueryString;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $paginate = 10;
    public $search;

    protected $updateQueryString = [
        ["search" => ["except" =>""]],
    ];

    public function mount()
    {
        $this->search = request()->query("search", $this->search);
    }

    public function render()
    {
        return view('livewire.product.index', [
            "products" => @$this->search === null 
                ? Product::latest()->paginate($this->paginate) 
                : Product::latest()->where("name", "like", "%" . $this->search . "%")->paginate($this->paginate)
        ]);
    }
}
