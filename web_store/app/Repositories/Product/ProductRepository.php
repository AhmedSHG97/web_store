<?php

namespace App\Repositories\Product;

use App\Models\Inventory;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Product::class;
    }
    public function assignInventories($product,$inventory_ids){
        foreach($inventory_ids as $inventory_id){
            $product->inventories()->save(Inventory::find($inventory_id));
        }
        return $product;
    }
}
