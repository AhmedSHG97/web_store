<?php

namespace App\Repositories\Invoice;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
/**
 * Class InvoiceRepository.
 */
class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Invoice::class;
    }
    public function deleteLastInvoiceDetails(){
        DB::table('invoice_products_details')->delete();
    }
    public function getTotal(){
        return Invoice::all()->sum('total');
    }
    public function getSubtotal(){
        return Invoice::all()->sum('subtotal');
    }    

}
