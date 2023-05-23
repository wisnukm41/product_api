<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryProductRequest;
use App\Http\Resources\CategoryProductResource;
use App\Services\CategoryProductService;
use Illuminate\Http\Request;

class CategoryProductController extends BaseController
{

    private $categoryProductService;

    public function __construct(CategoryProductService $categoryProductService)
    {
        $this->categoryProductService = $categoryProductService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $category = $this->categoryProductService->getAll();
        
        return $this->sendResponse(new CategoryProductResource($category), 'All Category Product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryProductRequest $request)
    {
        $category = $this->categoryProductService->store($request->only('name'));
        
        return $this->sendResponse(new CategoryProductResource($category), 'Category Product Created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryProductService->findOne($id);

        if(!$category) {
            return $this->sendError('Not Found', 'Category Product Not Found');
        }
        
        return $this->sendResponse(new CategoryProductResource($category), 'Find One Category Product');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryProductRequest $request, $id)
    {
        $category = $this->categoryProductService->update($id, $request->name);

        if(!$category) {
            return $this->sendError('Not Found', 'Category Product Not Found');
        }

        return $this->sendResponse(new CategoryProductResource($category), 'Category Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryProductService->delete($id);

        if(!$category) {
            return $this->sendError('Not Found', 'Category Product Not Found');
        }

        return $this->sendResponse('Deleted', 'Category Product Deleted');
    }
}
