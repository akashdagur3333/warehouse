<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customertransactionhistory;
use App\Models\Customertransaction;
use DataTables;
use Auth;

class CustomertransactionhistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactioncode=Customertransaction::get()->pluck('transaction_code','transaction_code')->toArray();
        $customer=Customertransaction::get()->pluck('customer','customer')->toArray();
        return view('backend/master/custtransactionhistoy-list',compact('customer','transactioncode'));
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

    public function getCustomertransactionDatalist(Request $request){
        $transaction_code=$request->transactioncode;$customer=$request->customer;
        $fromdate=$request->from_date;$todate=$request->to_date;
        
         //var_dump($supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate);
        ///return response()->json(['msg'=>$supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate]);

        // where('supplier_name', '=', $supplier_name)
        // ->where('product', '=', $product)
        // ->
        $data = Customertransaction::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        //var_dump($data);
        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                
                ->make(true);
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
