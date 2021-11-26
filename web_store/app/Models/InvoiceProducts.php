<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;
    protected $table = "invoice_products";
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'sales_price',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
