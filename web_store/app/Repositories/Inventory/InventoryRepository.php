<?php

namespace App\Repositories\Inventory;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class InventoryRepository.
 */
class InventoryRepository extends BaseRepository implements InventoryRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Inventory::class;
    }
    public function detachAllInventories($product_id){
        DB::table('products_inventories')->where('product_id',$product_id)->delete();
    }
}
