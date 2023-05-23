<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAll()
    {
        return Product::get();
    }

    public function store($request)
    {   
        if($image = $request->file('image')){
            $image_path = $image->store('product','public');
        } else {
            $image_path = 'product/default.png';
        }

        $data = $request->only('name','price','image','product_category_id');

        $data['image'] = $image_path;

        return Product::create($data);
    }

    public function findOne($id)
    {
        $category = Product::find($id);

        if(!$category) {
            return false;
        }

        return $category;
    }

    public function update($id, $request)
    {
        $product = $this->findOne($id);

        if(!$product){
            return false;
        }

        if($image = $request->file('image')){

            $old_path = $product->image;

            if(Storage::exists("$old_path") && $old_path !== 'product/default.png'){
                Storage::delete($old_path);
            };

            $product->image = $image->store('product','public');
        }

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->product_category_id = $request->input('product_category_id');
        $product->save();

        return $product;
    }

    public function delete($id){

        $category = $this->findOne($id);

        if(!$category){
            return false;
        }

        return $category->delete();
    }
}
