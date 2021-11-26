<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safe extends Model
{
    use HasFactory;

    protected $table = "safes";

    protected $fillable = [
        'name',
        'total_amount',
    ];
    public function transactions(){
        return $this->hasMany(SafeTransactions::class);
    }
}
