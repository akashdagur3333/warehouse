<?php

namespace App\Http\Controllers;
use DataTables;
use Auth;
use App\Models\Rawmaterial;
use Illuminate\Http\Request;
use App\Models\Rawmaterialnameentry;
use App\Http\Controllers\RawmaterialledgerController;

class RawmaterialledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials=Rawmaterialnameentry::get()->pluck( 'material_entry','id')->toArray();
        return view('backend/master/rawmaterial-ledger', compact('materials'));
    }


    
    public function getMaterialledgerDatalist(Request $request){
        $material=$request->material;
       $data = Rawmaterial::where('product_name', [$material])
        ->get();
        return Datatables::of($data)
        ->addIndexColumn()

        ->editColumn('updated_at', function($row){ 
                return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
             }) 
             ->addColumn('product_name', function($row){
                $sup= Rawmaterialnameentry::where('id', $row->product_name)->pluck('material_entry');
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
