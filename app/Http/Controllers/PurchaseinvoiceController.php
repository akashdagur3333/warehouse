<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseinvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choose_invoice = Purchase::get()->pluck('invoice_no','id')->toArray();
        return view('backend/master/purchase-invoice',compact('choose_invoice'));
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

    
    public function getSuplireDetail(Request $request)
    {
        $id=$request->id;
        //var_dump($id);
        $data = Purchase::find($id);
        $Sup = Vendor::find($data['supplier_name']);
        return response()->json(['purchase_id'=>$data['purchase_id'],'supplier_name'=>$Sup['company'],'supplier_mobile' => $data['supplier_mobile'],'supplier_address' => $data['supplier_address'],'purchase_by' => $data['purchase_by'],'invoice_no' => $data['invoice_no'],
        'purchase_date' => $data['purchase_date'],'product' => $data['product'],'purchase_rate' => $data['purchase_rate'],'quantity' => $data['quantity'],'discount_tk' => $data['discount_tk'],'total' => $data['total'],'vat_tk' => $data['vat_tk'],
        'transport_cost' => $data['transport_cost'],'totalam' => $data['totalam'],'paid' => $data['paid'],'due' => $data['due']
    
    ]);
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
