<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Vendor;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Purchasereturnentry;

class VendorledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Vendor::get()->pluck('company','id')->toArray();
        return view('backend/master/vendor-ledger',compact('supplier'));
    }


    public function getVendorledgerDatalist(Request $request){
        //$data=::select("SELECT * FROM `customer` WHERE created_at BETWEEN '$fromdate' AND '$todate'")
        $supplier=$request->supplier;
        //  $fromdate=$request->from_date;$todate=$request->to_date;
        
         //var_dump($supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate);
        ///return response()->json(['msg'=>$supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate]);

        // where('supplier_name', '=', $supplier_name)
        // ->where('product', '=', $product)
        // ->
       $data = Purchase::where('supplier_name', [$supplier])
      //  $data = Purchase::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        return Datatables::of($data)
        ->addIndexColumn()

        ->editColumn('updated_at', function($row){ 
                return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
             }) 
             ->addColumn('supplier_name', function($row){
                $sup= Vendor::where('id', $row->supplier_name)->pluck('company');
                //dd($sta);
                return $sup[0];
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
