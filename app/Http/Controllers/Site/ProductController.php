<?php

namespace App\Http\Controllers\Site;

use App\Action\Product\CreateProductAction;
use App\Action\Product\UpdateProductAction;
use App\Action\ProductHistory\UpdateProductHistoryAction;
use App\DTO\Product\CreateProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $products = Product::paginate(10);
        return view('site.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(): View|Factory|Application
    {
        $this->authorize('create',Product::class);
        return view('site.product.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param CreateProductAction $action
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ProductRequest $request, CreateProductAction $action): RedirectResponse
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
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Product $product): View|Factory|Application
    {
        $this->authorize('create',Product::class);
        return view('site.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param UpdateProductAction $action
     * @param Product $product
     * @param UpdateProductHistoryAction $ac
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ProductRequest $request, UpdateProductAction $action ,Product $product ,UpdateProductHistoryAction $ac): RedirectResponse
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
     * @return Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('create',$product);
        $product->delete();
        return  redirect()->back();
    }
}
