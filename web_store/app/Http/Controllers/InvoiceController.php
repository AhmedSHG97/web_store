<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\SafeRequest;
use Illuminate\Http\Request;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function __construct(InvoiceRepositoryInterface $invoiceRepository, ProductRepositoryInterface $productRepository)
    {
        $this->repository = $invoiceRepository;
        $this->productRepository = $productRepository;
    }

    public function all()
    {
        if (!userSession()->hasPermissionTo('show-invoices') && !userSession()->hasRole('admin')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $invoices = $this->repository->all();
        return view('website.invoice.all')->with([
            'title' => __("website.title_invoice"),
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        if (!(userSession()->hasPermissionTo('modify-invoices') || userSession()->hasRole('admin'))) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $this->repository->deleteLastInvoiceDetails();
        $products = $this->productRepository->all();
        return view("website.invoice.create")->with([
            'title' => __("website.create_invoice"),
            'products' => $products
        ]);
    }

    public function store(InvoiceRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if (session()->has('validation_message')) {
            return redirect()->back()->withErrors(['message' => session("validation_message")])->withInput();
        }
        $total = 0;
        $subtotal = 0;
        $invoiceProducts = DB::table('invoice_products_details')->get();
        if (count($invoiceProducts) == 0) {
            return redirect()->back()->withErrors(['message' => __("website.text_products_required")])->withInput();
        }
        foreach ($invoiceProducts as $product) {
            $product_info = $this->productRepository->getById($product->product_id);
            if ($product->quantity > $product_info->quantity) {
                return redirect()->back()->withErrors(['message' => __("website.quantity_validation_error")])->withInput();
            }
            $this->productRepository->updateById($product_info->id, ['quantity' => (int)$product_info->quantity - (int)$product->quantity]);
            $subtotal += $product_info->cost_price * $product->quantity;

            $total += $product->quantity * $product->sales_price;
        }

        $invoice = $this->repository->create(array_merge($request->validated(), [
            'user_id' => userSession()->id,
            'total' => $total,
            'subtotal' => $subtotal,
        ]));
        foreach ($invoiceProducts as $product) {
            DB::table('invoice_products')->insertGetId([
                'product_id' => $product->product_id,
                'sales_price' => $product->sales_price,
                'quantity' => $product->quantity,
                'invoice_id' => $invoice->id,
            ]);
        }
        return redirect()->back()->with(['success' => __("website.info_invoice_created_success")]);
    }
    public function storeInvoiceProducts(Request $request)
    {
        if ($request->status == "true") {
            DB::table('invoice_products_details')->insertGetId([
                'product_id' => $request->product_id,
                'sales_price' => $request->price,
                'quantity' => $request->quantity,
            ]);
        } else if ($request->status == "false") {
            DB::table('invoice_products_details')->where('product_id', $request->producr_id)->delete();
        }
        return true;
    }

    public function print($id)
    {
        $invoice = $this->repository->getById($id);
        return view('website.invoice.print')->with([
            'invoice' => $invoice,
        ]);
    }

    public function delete(Request $request)
    {
        $this->repository->deleteById($request->id);
        $invoices = $this->repository->all();
        return view("website.invoice.components.table")->with(['invoices' => $invoices]);
    }
}
