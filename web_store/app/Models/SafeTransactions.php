<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeTransactions extends Model
{
    use HasFactory;

    protected $table = "safe_transactions";
    
    protected $fillable = [
        "user_id",
        "safe_id",
        "transaction_amount",
        "transaction_type",
        "safe_credit",
    ];
    public function safe(){
        return $this->belongsTo(Safe::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
