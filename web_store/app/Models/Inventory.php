<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->products->sum('cost_price');
    }
}
