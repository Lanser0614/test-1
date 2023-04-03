<?php


namespace App\Action\ProductHistory;


use App\DTO\Product\CreateProductDTO;
use App\Models\Product;
use App\Models\ProductHistory;

class UpdateProductHistoryAction
{

    public  function run(Product $product , CreateProductDTO $dto): void
    {

        $productHis = new ProductHistory();
        $productHis->status = "update";
        $productHis->user_id = auth()->user()->id;
        $productHis->product_id = $product->id;
        $productHis->title = $dto->getTitle();
        $productHis->quantity = $dto->getQuantity();
        $productHis->price = $dto->getPrice();
        $productHis->total_price = $dto->getQqs();
        $productHis->save();
    }
}
