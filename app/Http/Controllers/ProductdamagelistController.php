<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Productnameentry;
use App\Models\Productdamagelist;
use App\Models\Productdamageentry;

class ProductdamagelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/productdamagelist-list');
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

    public function getProductdamageentryDatalist(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
        
        $data = Productdamageentry::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                     ->addcolumn('damage_product', function($row){
                        $damage = Productnameentry::where('id', $row->damage_product)->pluck('product_entry')->toArray();
                        return $damage;
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
