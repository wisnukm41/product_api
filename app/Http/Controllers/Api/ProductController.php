<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = $this->productService->getAll();
        
        return $this->sendResponse(ProductResource::collection($product), 'All Product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request);

        return $this->sendResponse(new ProductResource($product),'Product Created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productService->findOne($id);

        if(!$product) {
            return $this->sendError('Not Found', 'Product Not Found');
        }
        
        return $this->sendResponse(new ProductResource($product), 'Find One Product');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {   
        $product = $this->productService->update($id, $request);

        if(!$product) {
            return $this->sendError('Not Found', 'Product Not Found');
        }

        return $this->sendResponse(new ProductResource($product), 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productService->delete($id);

        if(!$product) {
            return $this->sendError('Not Found', 'Product Not Found');
        }

        return $this->sendResponse('Deleted', 'Product Deleted');
    }
}
