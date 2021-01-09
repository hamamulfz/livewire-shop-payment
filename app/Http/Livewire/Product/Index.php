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
    public $formVisible;
    public $formUpdate = false;

    protected $updateQueryString = [
        ["search" => ["except" =>""]],
    ];

    protected  $listeners = [
        "formClose" => "formCloseHandler",
        "productStored" => "productStoredHandler",
        "productUpdated" => "productUpdatedHandler"
    ];

    public function showCreate()
    {
        if($this->formVisible){
            $this->formVisible = true;
        } else {
            $this->formVisible = false;

        }
    }

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
    public function formCloseHandler()
    {
        # code...
        $this->formVisible = false;
    }
    public function productStoredHandler()
    {
        # code...
        $this->formVisible = false;
        session()->flash("message", "Your product successfully added.");
    }
    
    public function editProduct($id)
    {
        # code...
        $this->formUpdate = true;
        $this->formVisible = true;
        $product = Product::find($id);
        $this->emit('editProduct', $product );
    }

    public function productUpdatedHandler()
    {
        # code...
        $this->formVisible = false;
        session()->flash("message", "Your product successfully updated.");
    }
}
