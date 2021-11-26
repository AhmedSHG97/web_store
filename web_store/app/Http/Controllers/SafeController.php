<?php

namespace App\Http\Controllers;

use App\Http\Requests\SafeRequest;
use Illuminate\Http\Request;
use App\Repositories\Safe\SafeRepositoryInterface;

class SafeController extends Controller
{
    public function __construct(SafeRepositoryInterface $safeRepository)
    {
        $this->repository = $safeRepository;
    }

    public function all()
    {
        if (!userSession()->hasPermissionTo('show-safe') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $safes = $this->repository->all();
        return view('website.safe.all')->with([
            'title' => __("website.title_safe"),
            'safes' => $safes
        ]);
    }

    public function create()
    {
        if (!(userSession()->hasPermissionTo('modify-safe') || userSession()->hasRole('admin'))) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        return view("website.safe.create")->with(['title' => __("website.create_safe")]);
    }

    public function store(SafeRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        $this->repository->create($request->validated());
        return redirect()->back()->with(['success' => __("website.info_safe_created_success")]);
    }

    public function edit($safe_id)
    {
        if (!userSession()->hasPermissionTo('modify-safe') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $safe = $this->repository->getById($safe_id);
        $safeTransactions = $safe->transactions;
        return view('website.safe.edit')->with([
            'title' => __('website.text_edit_safe'), 
            'safe' => $safe,
            'safeTransactions' => $safeTransactions,
        ]);
    }

    public function update(SafeRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }
        $safe = $this->repository->getById($request->id);
        
        $safe->update($request->validated());
        $safe->save();
        return redirect()->back()->with(['success' => __("website.info_safe_updated_success")]);
    }

    public function delete(Request $request)
    {
        $this->repository->deleteById($request->id);
        $safes = $this->repository->all();
        return view("website.safe.components.table")->with(['safes' => $safes]);
    }
}
