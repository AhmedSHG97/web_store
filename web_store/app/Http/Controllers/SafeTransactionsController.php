<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SafeTransactionRequest;
use App\Repositories\SafeTransactions\SafeTransactionRepositoryInterface;
use App\Repositories\Safe\SafeRepositoryInterface;

class SafeTransactionsController extends Controller
{
    public function __construct(SafeTransactionRepositoryInterface $safeTransactionsRepository, SafeRepositoryInterface $safeRepository)
    {
        $this->repository = $safeTransactionsRepository;
        $this->safeRepository = $safeRepository;
        
    }

    public function store(SafeTransactionRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if(session()->has('validation_message')){
            return redirect()->back()->withErrors(['message'=>session("validation_message")])->withInput();
        }

        $safe = $this->safeRepository->getById($request->safe_id);
        if( $safe->total_amount < (int)$request->transaction_amount && $request->transaction_type == "withdraw"){
            return redirect()->back()->withErrors(['message'=>__('website.transaction_amount_not_validated')])->withInput();

        }
        if($request->transaction_type == 'withdraw'){
            $safe->update(['total_amount'=>$safe->total_amount - $request->transaction_amount]);
        }else{
            $safe->update(['total_amount'=>$safe->total_amount + $request->transaction_amount]);
        }
        $safe->save();
        $safe->refresh();
        $this->repository->create(array_merge($request->validated(),['safe_credit' => $safe->total_amount]));
        return redirect()->back()->with(['success' => __("website.info_safe_transaction_created_success")]);
    }

    /*public function delete(Request $request)
    {
        $this->repository->deleteById($request->id);
        $safeTransactions = $this->repository->all();
        return view("website.safe.components.safe_transactions_table.blade")->with(['safeTransactions' => $safeTransactions]);
    }*/
   
}
