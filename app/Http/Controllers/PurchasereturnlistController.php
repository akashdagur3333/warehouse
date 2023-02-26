<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Rawmaterial;
    
use Illuminate\Http\Request;
use App\Models\Purchasereturnlist;
use App\Models\Purchasereturnentry;
use App\Models\Rawmaterialnameentry;

class PurchasereturnlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $supplier = Vendor::get()->pluck('company','id')->toArray();
        $product = Rawmaterialnameentry::get()->pluck('material_entry','id')->toArray();
        return view('backend/master/purchase-return-list',compact('supplier','product'));
    
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

    public function getPurchasereturnentryDatalist(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
        $data = Purchasereturnentry::whereBetween('created_at', [$fromdate, $todate])
        ->get();
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
