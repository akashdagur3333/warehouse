<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Productledger;
use App\Models\Productnameentry;
use App\Http\Controllers\ProductledgerController;

class ProductledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Productnameentry::get()->pluck('product_entry','id')->toArray();
        return view('backend/master/productledger-list',compact('product'));
    }

    public function getProductledgerDatalist(Request $request){
        //$data=::select("SELECT * FROM `customer` WHERE created_at BETWEEN '$fromdate' AND '$todate'")
        $product=$request->product;
        //  $fromdate=$request->from_date;$todate=$request->to_date;
        
         //var_dump($supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate);
        ///return response()->json(['msg'=>$supplier_name.'/'.$product.'/'.$fromdate.'/'.$todate]);

        // where('supplier_name', '=', $supplier_name)
        // ->where('product', '=', $product)
        // ->
       $data = Product::where('name', [$product])->get();
        return Datatables::of($data)
        ->addIndexColumn()

        ->editColumn('updated_at', function($row){ 
                return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
             }) 
        ->addcolumn('name',function($row){
            $name=Productnameentry::where('id',$row->name)->pluck('product_entry')->toArray();
            return $name;
        })
            //  ->addColumn('name', function($row){
            //     $sup= Productnameentry::where('id', $row->name)->pluck('product_entry');
            //     //dd($sta);
            //     return $sup[0];
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
