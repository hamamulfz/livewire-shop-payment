<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    
    use WithFileUploads;

    public $title;
    public $description;
    public $price;
    public $image;

    public function render()
    {
        return view('livewire.product.create');
    }

    public function store()
    {

        $valdation = $this->validate([
            "title" => "required|min:3",
            "description" => "required|max:180",
            "price" => "required|numeric",
            // "image" => "image|max:10024",
        ]);
        $imageName = "";
        if ($this->image){
            $imageName = \Str::slug($this->title, "-")
                . "-"
                .uniqid()
                ."." . $this->image->getClientOriginalExtension();

                $this->image->storeAs("public", $imageName,  "local");
        }
        // dd($imageName);
        
        $product = [
            "name"=> $this->title,
            "description"=> $this->description,
            "price"=> $this->price,
            "image"=>  $imageName ,
        ];
Product::create($product);
        
$this->emit("productStored");
    }
}
