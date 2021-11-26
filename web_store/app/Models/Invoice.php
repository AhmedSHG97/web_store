<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "invoices";

    protected $fillable = [
        'subtotal',
        'total',
        'user_id',
        'invoice_to',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->hasMany(InvoiceProducts::class);
    }
}
