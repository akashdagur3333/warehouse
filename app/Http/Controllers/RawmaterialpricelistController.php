<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Rawmaterial;
use Illuminate\Http\Request;
use App\Models\Rawmaterialnameentry;
use App\Models\Rawmaterialpricelist;
use App\Http\Controllers\RawmaterialpricelistController;


class RawmaterialpricelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/rawmaterialpricelist-list');
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

    public function getRawmaterialDatalist(Request $request){
        $fromdate=$request->from_date;$todate=$request->to_date;
        
        $data = Rawmaterial::whereBetween('created_at', [$fromdate, $todate])
        ->get();
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                
                     ->addcolumn('product_name', function($row) {
                        $name = Rawmaterialnameentry::where('id',$row->product_name)->pluck('material_entry');
                        return $name[0];
                    })
                    ->addcolumn('category', function($row) {
                        $cat = Category::where('id',$row->category)->pluck('name');
                        return $cat[0];
    
                     })
                    // ->addcolumn('material_unit', function($row) {
                    //     $unit = Unit::where('id',$row->material_unit)->pluck('unittype');
                    //     return $unit[0];
    
                    // })
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
