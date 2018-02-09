<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreUpdateProductApiValidate;

class ProductController extends Controller
{
    private $product;
    private $totalPage = 3;
    

    /**
     * DI of \App\Models\Product
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // For testing preloader (optional)
    	sleep(2);

        $products = $this->product->getResults($request->all(), $this->totalPage);
        
        return response()->json($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateProductApiValidate $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductApiValidate $request)
    {
        if ( !$product = $this->product->create($request->all()) )
            return response()->json(['error' => 'error_insert'], 500);
        
        return response()->json($product, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( !$product = $this->product->find($id) )
           return response()->json(['error' => 'product_not_found'], 404);
        
        return response()->json($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateProductApiValidate $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductApiValidate $request, $id)
    {
        if ( !$product = $this->product->find($id) )
           return response()->json(['error' => 'product_not_found'], 404);
        
        if ( !$product->update($request->all()) )
            return response()->json(['error' => 'product_not_update'], 500);
        
        return response()->json($product);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( !$product = $this->product->find($id) )
           return response()->json(['error' => 'product_not_found'], 404);
        
        if ( !$product->delete() )
            return response()->json(['error' => 'product_not_delete'], 500);
        
        return response()->json($product);
    }
}
