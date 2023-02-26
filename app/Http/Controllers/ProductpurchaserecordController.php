<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Rawmaterial;
use Illuminate\Http\Request;
use App\Models\Productnameentry;

class ProductpurchaserecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/product-purchase-record');
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

    public function getPurchaseDatalist(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
        $data = Purchase::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                
                     ->addColumn('supplier_name', function($row){
                        $sup= Vendor::where('id', $row->supplier_name)->pluck('company')->toArray();
                        return $sup;
                    })
                    ->addColumn('product', function($row){
                        $sup= Productnameentry::where('id', $row->product)->pluck('product_entry')->toArray();
                        return $sup;
                    })
                    // ->addColumn('product', function($row){
                    //     $pro= Rawmaterial::where('id', $row->product)->pluck('Product_name');
                    //     return $pro[0];
                    // })
                    
                ->make(true);
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
