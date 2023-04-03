<?php

namespace App\Http\Controllers\Site;

use App\Action\Product\CreateProductAction;
use App\Action\Product\UpdateProductAction;
use App\Action\ProductHistory\UpdateProductHistoryAction;
use App\DTO\Product\CreateProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('site.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Product::class);
        return view('site.product.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, CreateProductAction $action)
    {

        $this->authorize('create',Product::class);

        $dto = new CreateProductDTO(
            (string) $request->get('title'),
            (int)    $request->get('quantity'),
            (float)  $request->get('price'),
        );

        $action->run($dto);

       return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('create',Product::class);
        return view('site.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, UpdateProductAction $action ,Product $product ,UpdateProductHistoryAction $ac)
    {
        $this->authorize('create',Product::class);
        $dto = new CreateProductDTO(
            (string) $request->get('title',$product->title),
            (int)    $request->get('quantity',$product->quantity),
            (float)  $request->get('price',$product->price),
        );


        $action->run($product,$dto);
        $ac->run($product,$dto);


        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('create',$product);
        $product->delete();
        return  redirect()->back();
    }
}
