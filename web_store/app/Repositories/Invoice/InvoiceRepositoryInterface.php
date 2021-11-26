<?php

namespace App\Repositories\Invoice;

use Illuminate\Http\Request;
interface InvoiceRepositoryInterface
{
    public function getTotal();
    public function getSubtotal();
    

}