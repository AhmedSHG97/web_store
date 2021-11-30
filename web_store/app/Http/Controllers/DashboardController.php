<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Repositories\Safe\SafeRepositoryInterface;
use App\Models\Settings;
use App\Repositories\Product\ProductRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository, InvoiceRepositoryInterface $invoiceRepository, InventoryRepositoryInterface $inventoryRepository, SafeRepositoryInterface $safeRepository, ProductRepositoryInterface $productRepository, Settings $settingsModel )
    {
        $this->repository = $userRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->safeRepository = $safeRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->settingsModel = $settingsModel;
        $this->productRepository = $productRepository;
    }
    public function show(){
        $users = $this->repository->allWithoutAuthed();
        $invoices_total = $this->invoiceRepository->getTotal();
        $invoices_subtotal = $this->invoiceRepository->getSubtotal();
        $inventories = $this->inventoryRepository->all();
        $safes = $this->safeRepository->all();
        $productsTotalCostPrice = $this->productRepository->getTotalCostPrice();
        $productsTotalSalesPrice = $this->productRepository->getTotalSalesPrice();
        return view("website.layouts.home")->with([
            'title'=>__("website.titel_dashboard"), 
            "users" => $users,
            "invoices_total" => $invoices_total,
            "invoices_subtotal" => $invoices_subtotal,
            "inventories" => $inventories,
            "safes" => $safes,
            "productsTotalSalesPrice" => $productsTotalSalesPrice,
            "productsTotalCostPrice" => $productsTotalCostPrice,
        ]);
    }
    public function editSettings(){
        $settings = $this->settingsModel->orderBy('id','desc')->first();
        return view('website.settings.edit')->with(['settings'=>$settings, 'title' => __('website.title_settings') ]);
    }
    public function updateSettings(SettingsRequest $request){
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        $this->settingsModel->where('id',$request->id)->update([
            'app_name'=>$request->app_name,
            'app_phone'=>$request->app_phone,
            'address'=>$request->address,
        ]);
        return redirect()->back()->with(['success' => __("website.settings_updated_successfully")]);
    }
}
