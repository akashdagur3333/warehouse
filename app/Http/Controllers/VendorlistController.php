<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class VendorlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $supplier = Vendor::get()->pluck('company','company')->toArray();  
      return view('backend/master/vendor-list',compact('supplier'));
    }

    public function getVendorlistDatalist(Request $request){
        //$data=::select("SELECT * FROM `customer` WHERE created_at BETWEEN '$fromdate' AND '$todate'")
        $supplier=$request->supplier;
        
         //var_dump($supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate);
        ///return response()->json(['msg'=>$supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate]);

        // where('supplier_name', '=', $supplier_name)
        // ->where('product', '=', $product)
        // ->
        $data = Vendor::where('company', [$supplier])
        ->get();
        return Datatables::of($data)
        ->addIndexColumn()
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
