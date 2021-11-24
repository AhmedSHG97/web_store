<?php

namespace App\Repositories\Product;

use Illuminate\Http\Request;
use App\Models\Product;
interface ProductRepositoryInterface
{
    public function assignInventories(Product $product, array $inventory_ids);
}
