<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    
    protected $fillable = [
        "name",
        "image",
        "description",
        "inventory_id",
        "category_id",
        "cost_price",
        "sales_price",
        "quantity",
    ];
    public function inventories(){
        return $this->belongsToMany(Inventory::class,"products_inventories")->select(array('inventory_id','product_id','id','address','name','image','quantity'));
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function getInventoriesIdsAttribute(){
        return $this->inventories->pluck('id')->toArray();
    }
}
