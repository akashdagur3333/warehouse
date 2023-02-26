<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customertransaction;

class CustomertransactioninvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choose_invoice = Customertransaction::get()->pluck('invoice_no','id')->toArray();
        return view('backend/master/customer-transaction-invoice',compact('choose_invoice'));
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
        $data = Customertransaction::find($id);
        return response()->json(['invoice_no'=>$data['invoice_no'],'customer'=>$data['customer'],'cust_institution'=>$data['cust_institution'],'transaction_code' => $data['transaction_code'],'entry_date' => $data['entry_date'],'payment_method' => $data['payment_method'],'bankacc_name' => $data['bankacc_name'],
        'current_due' => $data['current_due'],'amount' => $data['amount']
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
