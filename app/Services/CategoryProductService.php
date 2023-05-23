<?php

namespace App\Services;

use App\Models\ProductCategory;

class CategoryProductService
{
    public function getAll()
    {
        return ProductCategory::all();
    }

    public function store($data)
    {
        return ProductCategory::create($data);
    }

    public function findOne($id)
    {
        $category = ProductCategory::find($id);

        if(!$category) {
            return false;
        }

        return $category;
    }

    public function update($id, $value)
    {
        $category = $this->findOne($id);

        if(!$category){
            return false;
        }

        $category->name = $value;
        $category->save();

        return $category;
    }

    public function delete($id){

        $category = $this->findOne($id);

        if(!$category){
            return false;
        }

        return $category->delete();
    }
}
