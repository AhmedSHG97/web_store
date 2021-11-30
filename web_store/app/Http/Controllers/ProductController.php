<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Requests\ProductRequest;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(ProductRepositoryInterface $productRepository, InventoryRepositoryInterface $inventoryRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->repository = $productRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function all(Request $request)
    {
        if (!userSession()->hasPermissionTo('show-products') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if ($request->has("from")) {
            $products = $this->repository->where('quantity', $request->from, ">=")->where('quantity', $request->to, "<=")->get();
        } else {
            $products = $this->repository->all();
        }
        return view('website.product.all')->with([
            'title' => __("website.title_products"),
            'products' => $products
        ]);
    }

    public function create()
    {
        if (!userSession()->hasPermissionTo('modify-products') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if (!userSession()->hasPermissionTo('modify-products') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $categories = $this->categoryRepository->all();
        $inventories = $this->inventoryRepository->all();
        return view("website.product.create")->with([
            'title' => __("website.create_products"),
            'inventories' => $inventories,
            'categories' => $categories
        ]);
    }

    public function store(ProductRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if (session()->has('validation_message')) {
            return redirect()->back()->withErrors(['message' => session("validation_message")])->withInput();
        }
        $coutner = 0;
        foreach ($request->inventories as $inventory) {
            if($inventory == null){
                $coutner ++;
            }
        }
        if (count($request->inventories) == $coutner) {
            return redirect()->back()->withErrors(['message' => __("يجب اضافة الكميات في المخازن")])->withInput();
        }
        if(isset($request->image)){
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/product'), $image);
        }else{
            $image = 'placeholder.png';
        }
        $product = $this->repository->create(array_merge($request->except('image', 'inventories'), ['image' => "uploads/product/" . $image]));
        if ($request->has('inventories')) {
            $this->repository->assignInventories($product, $request->inventories);
        }
        return redirect()->back()->with(['success' => __("website.info_product_created_success")]);
    }

    public function edit($product_id)
    {
        if (!userSession()->hasPermissionTo('modify-products') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $categories = $this->categoryRepository->all();
        $inventories = $this->inventoryRepository->all();
        $product = $this->repository->getById($product_id);
        return view('website.product.edit')->with([
            'title' => __('website.text_edit_product'),
            'product' => $product,
            'inventories' => $inventories,
            'categories' => $categories
        ]);
    }

    public function update(ProductRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if (session()->has('validation_message')) {
            return redirect()->back()->withErrors(['message' => session("validation_message")])->withInput();
        }
        $coutner = 0;
        foreach ($request->inventories as $inventory) {
            if($inventory == null){
                $coutner ++;
            }
        }
        if (count($request->inventories) == $coutner) {
            return redirect()->back()->withErrors(['message' => __("يجب اضافة الكميات في المخازن")])->withInput();
        }
        $product = $this->repository->getById($request->id);
        if ($request->has('image')) {
            File::delete($product->image);
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/product'), $image);
            $path = "uploads/product/" . $image;
        } else {
            $path = $product->image;
        }
        $this->inventoryRepository->detachAllInventories($product->id);
        if ($request->has('inventories')) {
            $this->repository->assignInventories($product, $request->inventories);
        }
        $product->update(array_merge($request->except('image', 'inventories'), ['image' => $path]));
        $product->save();
        return redirect()->back()->with(['success' => __("website.info_product_updated_success")]);
    }

    public function delete(Request $request)
    {
        $product = $this->repository->getById($request->id);
        File::delete($product->image);
        $this->repository->deleteById($request->id);
        $products = $this->repository->all();
        return view("website.product.components.table")->with(['products' => $products]);
    }
    public function productsFilter(Request $request)
    {
    }
}
