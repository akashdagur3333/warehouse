<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Rawmaterial;
use Illuminate\Http\Request;
use App\Http\Traits\CustomerTrait;

use App\Models\Rawmaterialnameentry;
use App\Http\Controllers\RawmaterialController;

class RawmaterialController extends Controller
{
    use CustomerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units=Unit::get()->pluck( 'unittype','id')->toArray();
        $categories=Category::get()->pluck( 'name','id')->toArray();
        $materials=Rawmaterialnameentry::get()->pluck( 'material_entry','id')->toArray();
        return view('backend/master/rawmaterial-list', compact('categories','units','materials'));
    }



    public function getRawmaterialData()
    {
        $data = Rawmaterial::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addcolumn('product_name', function($row) {
                    $name = Rawmaterialnameentry::where('id',$row->product_name)->pluck('material_entry')->toArray();
                    return $name;

                })
                ->addcolumn('category', function($row) {
                    $cat = Category::where('id',$row->category)->pluck('name')->toArray();
                    return $cat;

                })
                ->addcolumn('material_unit', function($row) {
                    $unit = Unit::where('id',$row->material_unit)->pluck('unittype')->toArray();
                    return $unit;
                })
                ->addColumn('action', function($row){

                    $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                    //    $btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

                    $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                        return $btn;
                })
                ->rawColumns(['status', 'action'])
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
        $this->validate($request, ['rawmaterial_code'=>'required','product_name'=>'required', 'category'=>'required', 'freshness'=>'required', 'material_unit'=>'required', 'price'=>'required', 're_order'=>'required', 'date'=>'required', 'status'=>'required']); 
        
        Rawmaterial::updateOrCreate(
                                    [
                                        'rawmaterial_code' => $request->rawmaterial_code,
                                        'product_name' => ucwords($request->product_name),
                                        'category' => $request->category, 
                                        'freshness' => $request->freshness, 
                                        'material_unit' => $request->material_unit, 
                                        'stock' => $request->stock,
                                        'price' => $request->price, 
                                        're_order'=> $request->re_order,
                                        'date'=> $request->date,
                                        'status'=> $request->status,
                                    ]
                                );    
        if($request->rawmaterial_id){
            $msg = "Rawmaterial Updated Successfully.";
        }
        else{
            $msg = "Rawmaterial Created Successfully.";
        }
        return response()->json(['msg'=>$msg]);
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
        $data = Rawmaterial::find($id);
        return response()->json($data);
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
        $del = Rawmaterial::find($id)->delete();
        return response()->json(['success'=>'Rawmaterial deleted successfully.']);
    }
}
