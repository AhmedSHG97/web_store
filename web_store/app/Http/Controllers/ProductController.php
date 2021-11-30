<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Requests\ProductRequest;
use App\Repositories\Inventory\InventoryRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\File;
use App\Http\Helpers\SimpleXLSX;
use Exception;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(ProductRepositoryInterface $productRepository, InventoryRepositoryInterface $inventoryRepository, CategoryRepositoryInterface $categoryRepository, SimpleXLSX $xlsx)
    {
        $this->repository = $productRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->categoryRepository = $categoryRepository;
        $this->xlsx = $xlsx;
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
            if ($inventory == null) {
                $coutner++;
            }
        }
        if (count($request->inventories) == $coutner) {
            return redirect()->back()->withErrors(['message' => __("يجب اضافة الكميات في المخازن")])->withInput();
        }
        if (isset($request->image)) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/product'), $image);
        } else {
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
            if ($inventory == null) {
                $coutner++;
            }
        }
        if (count($request->inventories) == $coutner) {
            return redirect()->back()->withErrors(['message' => __("يجب اضافة الكميات في المخازن")])->withInput();
        }
        $product = $this->repository->getById($request->id);
        if ($request->has('image')) {
            if($product->image != 'uploads/product/placeholder.png')
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
        if($product->image != 'uploads/product/placeholder.png')
        File::delete($product->image);
        $this->repository->deleteById($request->id);
        $products = $this->repository->all();
        return view("website.product.components.table")->with(['products' => $products]);
    }
    public function storeExcel(Request $request)
    {
        $request->validate(['products_file' => "required|mimes:xlsx"]);
        $file = $request->file('products_file');
        $excel = $this->xlsx::parse($file->getPathName());
        $file_columns = ['name', 'image', 'description', 'category', 'cost price', 'sales price', 'quantity'];
        $sheet_2_file_columns = ['name', 'inventory', 'quantity'];
        $i = 0;
        DB::beginTransaction();
        try{
            for ($sheet = 0; $sheet < sizeof($excel->sheetNames()); $sheet++) {
                foreach ($excel->rows($sheet) as $key => $row) {
                    if ($i != 0) {
                        if ($sheet == 0) {
                            if (!is_numeric((int)$row[5])) {
                                return redirect()->back()->withErrors(['message' => __("يجب ان تكون الكمية رقما")]);
                            }
                            $category = $this->categoryRepository->where('name', $row[2])->get()->first();
                            $product_info = $this->repository->where('name', trim($row[0]))->get()->first();
                            if ($category) {
                                $category_id = $category->id;
                            } else {
                                $category = $this->categoryRepository->create(['name' => $row[2], 'image' => "uploads/product/placeholder.png"]);
                                $category_id = $category->id;
                            }
                            if ($product_info) {
                                $product_info->increment('quantity', (int)$row[5]);
                                $product_info->save();
                                echo "<br>" . $product_info->name . " تم تعديل الكمية للمنتج";
                            } else {
                                $product = [
                                    'name' => $row[0] ? trim($row[0]) : "product" . $i,
                                    'image' => "uploads/product/placeholder.png",
                                    'description' => $row[1] ? $row[1] : "product" . $i,
                                    'category_id' => $category_id,
                                    'cost_price' => $row[3],
                                    'sales_price' => $row[4],
                                    'quantity' => $row[5],
                                ];
                                $product_added = $this->repository->create($product);
                                echo "<br>" . $product_added->name . " تم الانشاء للمنتج";
                            }
                        }elseif($sheet == 1){
                            if (!is_numeric((int)$row[2])) {
                                return redirect()->back()->withErrors(['message' => __("في الشيت الثاني يجب ان تكون الكمية رقما")]);
                            }
                            $product_info = $this->repository->where('name', trim($row[0]))->get()->first();
                            $inventory = $this->inventoryRepository->where('name', $row[1])->get()->first();
                            if ($inventory) {
                                $inventory_id = $inventory->id;
                            } else {
                                $inventory = $this->inventoryRepository->create(['name' => $row[1],'address'=>'الأسكندرية' ,'image' => "uploads/product/placeholder.png"]);
                                $inventory_id = $inventory->id;
                            }
                            if ($product_info) {
                                $exists = DB::table('products_inventories')->where('inventory_id',$inventory_id)
                                ->where('product_id',$product_info->id)->get()->first();
                                if($exists){
                                    DB::table('products_inventories')
                                    ->where('inventory_id',$inventory_id)
                                    ->where('product_id',$product_info->id)->increment('quantity',(int)$row[2]);
                                }else{
                                    DB::table('products_inventories')->insertGetId([
                                        'product_id' => $product_info->id,
                                        'inventory_id' => $inventory_id,
                                        'quantity' => (int)$row[2],
                                    ]);
                                }
                                echo "<br>" . $product_info->name . " تم تعديل الكمية في الفرع للمنتج";
                                
                            } 
                            
                        }
                    } else {
                        if($sheet == 0){
                            foreach ($row as $key => $value) {
                                if (!in_array($value, $file_columns)) {
                                    DB::rollBack();
                                    return redirect()->back()->withErrors(['message' => __($value . "  لا يجب ان يحتوي الملف على ")]);
                                }
                                
                            }
                        }elseif($sheet == 1){
                            foreach ($row as $key => $value) {
                                if (!in_array($value, $sheet_2_file_columns)) {
                                    DB::rollBack();
                                    return redirect()->back()->withErrors(['message' => __($value . "  لا يجب ان يحتوي الملف على ")]);
                                }
                            }
                        }
    
                    }
                    $i++; 
                }
                $i = 0;
            }
        }catch(Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors(['message' =>$exception->getMessage()]);
        }
        
        DB::commit();
        return redirect()->back()->with(['success' => __("تم انشاء المنتجات بنجاح")]);
    }
    public function productsFilter(Request $request)
    {
    }
}
