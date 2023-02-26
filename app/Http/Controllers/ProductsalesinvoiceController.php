<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use App\Models\Sales;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductsalesinvoiceController;

class ProductsalesinvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $choose_invoice = Purchase::get()->pluck('invoice_no','id')->toArray();
        return view('backend/master/product-sales-invoice');

    }



    public function getSalesData(Request $request){
        $itm = Sales::find($request->id);
         $data = Customer::find($itm["customer_name"]);
         $customer_name = $data["cust_name"];
         $customer_mobile = $itm["customer_mobile"];
         $customer_address = $itm["customer_address"];
         $product = $itm["product"];
         $sales_rate = $itm["sales_rate"];
         $quantity = $itm["quantity"];
         $sales_by = $itm["sales_by"];
         $invoice_no = $itm["invoice_no"];
         $sales_date = $itm["sales_date"];
         $total = $itm["total"];
         $vat_tk = $itm["vat_tk"];
         $discount_tk = $itm["discount_tk"];
         $transport_cost = $itm["transport_cost"];
         $totalam = $itm["totalam"];
         $paid = $itm["paid"];
         $due = $itm["due"];
         return view('backend/master/product-sales-invoice',compact('customer_name','customer_mobile','customer_address','sales_by','invoice_no','sales_date','total','discount_tk','vat_tk','transport_cost','totalam','paid','due','product','sales_rate','quantity'));
     }
 
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
