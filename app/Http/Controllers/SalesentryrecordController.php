<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\User;
use App\Models\Order;
use App\Models\Sales;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesentryrecordController;

class SalesentryrecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/salesentry-record-list');
    }

    public function getSalesEntryrecordData(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
       
        $data = Sales::whereBetween('sales_date', [$fromdate, $todate])
        ->get();
        //var_dump($data);
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row){
                    $icon= Customer::where('id' , $row->customer_name)->pluck('cust_name')->toArray();
                    // dd($icon[0]);
                    return $icon;
                }) 
               
                ->addColumn('sales_by', function($row){
                    $icon= Employee::where('id' , $row->sales_by)->pluck('name')->toArray();
                    // dd($icon[0]);
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
            
                
                ->make(true);
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
