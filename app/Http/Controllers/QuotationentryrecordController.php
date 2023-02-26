<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\User;
use App\Models\Quotationorder;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;

class QuotationentryrecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/quotationentry-record-list');
    }

    public function getQuotationEntryrecordData(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
       
        $data = Quotationorder::whereBetween('sales_date', [$fromdate, $todate])
        ->get();
        //var_dump($data);
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name')->toArray();
                    // dd($icon[0]);
                    return $icon;
                }) 
                ->addColumn('created_by', function($row){
                    $icon= User::where('id' , $row->created_by)->pluck('email')->toArray();
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
                ->addColumn('action', function($row){  
                    
                    $btn = ' <abbr title="View Invoice"><a href='.url('quotationinvoice/'.base64_encode($row->ord_id).'').' data-toggle="tooltip"  data-id="'.$row->ord_id.'" data-original-title="View Invoice" class="btn btn-secondary btn-sm viewInvoice"><i class="zmdi zmdi-receipt"></i></a></abbr>';         

                    return $btn;
                })
                ->rawColumns(['action'])
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
