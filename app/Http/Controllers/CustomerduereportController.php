<?php

namespace App\Http\Controllers;
use DataTables;
use Auth;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Customerduereport;
use App\Http\Controllers\CustomerduereportController;

class CustomerduereportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/customerduereport-list');
    }

    public function getCustomerduereportDatalist(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
        $data = Customer::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        return Datatables::of($data)
        ->addIndexColumn()

        ->editColumn('updated_at', function($row){ 
                return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
             }) 
            //  ->addColumn('supplier_name', function($row){
            //     $sup= Vendor::where('id', $row->supplier_name)->pluck('company')->toArray();
            //     return $sup;
            // })
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
