<?php

namespace App\Repositories\Product;

use App\Models\Inventory;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
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
        foreach($inventory_ids as $key => $quantity){
            // $product->inventories()->save(Inventory::find($inventory_id));
            if($quantity != null){
                DB::table('products_inventories')->insertGetId([
                    'product_id' => $product->id,
                    'inventory_id' => $key,
                    'quantity' => $quantity,
                ]);
            }
            
        }
        
        return $product;
    }
}
