<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Repositories\Safe\SafeRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository, InvoiceRepositoryInterface $invoiceRepository, InventoryRepositoryInterface $inventoryRepository, SafeRepositoryInterface $safeRepository)
    {
        $this->repository = $userRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->safeRepository = $safeRepository;
        $this->inventoryRepository = $inventoryRepository;
        
    }
    public function show(){
        $users = $this->repository->allWithoutAuthed();
        $invoices_total = $this->invoiceRepository->getTotal();
        $invoices_subtotal = $this->invoiceRepository->getSubtotal();
        $inventories = $this->inventoryRepository->all();
        $safes = $this->safeRepository->all();
        return view("website.layouts.home")->with([
            'title'=>__("website.titel_dashboard"), 
            "users" => $users,
            "invoices_total" => $invoices_total,
            "invoices_subtotal" => $invoices_subtotal,
            "inventories" => $inventories,
            "safes" => $safes,
        ]);
    }
}
