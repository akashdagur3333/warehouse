<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Salesreturnentry;
use App\Http\Controllers\SalesreturnlistController;

class SalesreturnlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/sales-return-list');
    
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

    public function getSalesreturnentryDatalist(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
        $data = Salesreturnentry::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                     ->addColumn('customer_name', function($row){
                        $sup= Customer::where('id', $row->customer_name)->pluck('cust_name')->toArray();
                        return $sup;
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
