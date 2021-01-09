<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{

    
    use WithFileUploads;

    public $productId;
    public $title;
    public $description;
    public $price;
    public $image;
    public $imageOld;

    protected $listeners = [
        'editProduct' => 'editProductHandle'
    ];

    
    public function render()
    {
        return view('livewire.product.update');
    }

    public function editProductHandle($product)
    {
        # code...
        $this->productId = $product["id"];
        $this->title = $product["name"];
        $this->description = $product["description"];
        $this->price = $product["price"];
        $this->imageOld = asset('/storage/' . $product["id"]) ;
        // dd($this->imageOld);
    }

    public function update()
    {
        # code...
        
        $valdation = $this->validate([
            "title" => "required|min:3",
            "description" => "required|max:180",
            "price" => "required|numeric",
            // "image" => "image|max:1024",
        ]);
        if($this->productId){
            $product = Product::find($this->productId);
            Storage::disk("public")->delete($product->image);

            $imageName = \Str::slug($this->title, "-")
            . "-"
            .uniqid()
            ."." . $this->image->getClientOriginalExtension();

            $this->image->storeAs("public", $imageName,  "local");
            $this->image = $imageName;

        } 

        $product->update(
            [
            "name"=> $this->title,
            "description"=> $this->description,
            "price"=> $this->price,
            "image"=>  $this->image ,
        ]);
        
        $this->emit("productUpdated");
        

            
    }
}
