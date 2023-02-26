<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Purchase;
use Illuminate\Http\Request;

class ProductpurchaseinvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {    $choose_invoice = Purchase::get()->pluck('invoice_no','id')->toArray();
        
        return view('backend/master/product-purchase-invoice',compact('choose_invoice'));
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
    public function getPurchaseData(Request $request){
       $itm = Purchase::find($request->id);
        $choose_invoice = Purchase::get()->pluck('invoice_no','id')->toArray();
        $data = Vendor::find($itm["supplier_name"]);
        $purchase_id = $itm["purchase_id"];
        $supplier_name = $data["company"];
        $supplier_mobile = $itm["supplier_mobile"];
        $supplier_address = $itm["supplier_address"];
        $product = $itm["product"];
        $purchase_rate = $itm["purchase_rate"];
        $quantity = $itm["quantity"];
        $purchase_by = $itm["purchase_by"];
        $invoice_no = $itm["invoice_no"];
        $purchase_date = $itm["purchase_date"];
        $total = $itm["total"];
        $vat_tk = $itm["vat_tk"];
        $discount_tk = $itm["discount_tk"];
        $transport_cost = $itm["transport_cost"];
        $totalam = $itm["totalam"];
        $paid = $itm["paid"];
        $due = $itm["due"];
        return view('backend/master/product-purchase-invoice',compact('choose_invoice','supplier_name','supplier_mobile','supplier_address','purchase_by','invoice_no','purchase_date','total','discount_tk','vat_tk','transport_cost','totalam','paid','due','purchase_id','product','purchase_rate','quantity'));
    }

    public function getdata(Request $request)
    {
      
        
    }


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
