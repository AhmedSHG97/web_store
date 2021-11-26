<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use Illuminate\Http\Request;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    public function __construct(InventoryRepositoryInterface $inventoryRepository, ProductRepositoryInterface $productRepository)
    {
        $this->repository = $inventoryRepository;
        $this->productRepository = $productRepository;
    }

    public function all()
    {
        if (!userSession()->hasPermissionTo('show-inventories') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $inventories = $this->repository->all();
        return view('website.inventory.all')->with([
            'title' => __("website.title_inventories"),
            'inventories' => $inventories
        ]);
    }

    public function create()
    {
        if (!(userSession()->hasPermissionTo('modify-inventories') || userSession()->hasRole('admin'))) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        return view("website.inventory.create")->with(['title' => __("website.create_inventories")]);
    }

    public function store(InventoryRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        $image = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/inventory'), $image);
        $this->repository->create(array_merge($request->except('image'),['image' => "uploads/inventory/" . $image]));
        return redirect()->back()->with(['success' => __("website.infor_inventory_created_success")]);
    }

    public function edit($inventory_id)
    {
        if (!userSession()->hasPermissionTo('modify-inventories') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $inventory = $this->repository->getById($inventory_id);
        $products = $inventory->products;
        return view('website.inventory.edit')->with([
            'title' => __('website.text_edit_inventory'), 
            'inventory' => $inventory,
            'products' => $products
        ]);
    }

    public function update(InventoryRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        $inventory = $this->repository->getById($request->id);
        if ($request->has('image')) {
            File::delete($inventory->image);
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/inventory'), $image);
            $path = "uploads/inventory/" . $image;
        }else{
            $path = $inventory->image;
        }
        $inventory->update(array_merge($request->except('image'),['image' => $path]));
        $inventory->save();
        return redirect()->back()->with(['success' => __("website.info_inventory_updated_success")]);
    }

    public function delete(Request $request)
    {
        $inventory = $this->repository->getById($request->id);
        File::delete($inventory->image);
        $this->repository->deleteById($request->id);
        $inventories = $this->repository->all();
        return view("website.inventory.components.table")->with(['inventories' => $inventories]);
    }
}
