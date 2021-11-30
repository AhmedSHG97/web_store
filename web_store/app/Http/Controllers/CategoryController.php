<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function all()
    {
        if (!userSession()->hasPermissionTo('show-categories') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $categories = $this->repository->all();
        return view('website.category.all')->with([
            'title' => __("website.title_categories"),
            'categories' => $categories
        ]);
    }

    public function create()
    {
        if (!userSession()->hasPermissionTo('modify-categories') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        return view("website.category.create")->with(['title' => __("website.create_categories")]);
    }

    public function store(CategoryRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        if(isset($request->image)){
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/category'), $image);
        }else{
            $image = 'placeholder.png';
        }
        
        $this->repository->create(array_merge($request->except('image'),['image' => "uploads/category/" . $image]));
        return redirect()->back()->with(['success' => __("website.info_category_created_success")]);
    }

    public function edit($category_id)
    {
        if (!userSession()->hasPermissionTo('modify-categories') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $category = $this->repository->getById($category_id);
        $products = $category->products;
        return view('website.category.edit')->with(
            ['title' => __('website.text_edit_category'), 
            'category' => $category,
            'products' => $products
        ]);
    }

    public function update(CategoryRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        $category = $this->repository->getById($request->id);
        if ($request->has('image')) {
            File::delete($category->image);
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/category'), $image);
            $path = "uploads/category/" . $image;
        }else{
            $path = $category->image;
        }
        
        $category->update(array_merge($request->except('image'),['image' => $path]));
        $category->save();
        return redirect()->back()->with(['success' => __("website.info_category_updated_success")]);
    }

    public function delete(Request $request)
    {
        $category = $this->repository->getById($request->id);
        File::delete($category->image);
        $this->repository->deleteById($request->id);
        $categories = $this->repository->all();
        return view("website.category.components.table")->with(['categories' => $categories]);
    }
}
