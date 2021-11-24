<?php

namespace App\Repositories\Inventory;

use Illuminate\Http\Request;

interface InventoryRepositoryInterface
{
    public function detachAllInventories(int $product_id);
}
