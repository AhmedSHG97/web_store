<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;
    protected $table = "inventories";
    
    protected $fillable = [
        "name",
        "address",
        "image",
    ];
    public function products(){
        return $this->belongsToMany(Product::class,"products_inventories");
    }
    public function getCreditAttribute(){
        $products =  $this->products;
        $credit = 0;
        foreach ($products as $key => $product){
            $quantity = DB::table('products_inventories')->where('product_id',$product->id)->where('inventory_id',$this->id)->first()->quantity;
            
            $credit+= $product->cost_price * $quantity;
        }
        return $credit;
    }
}
