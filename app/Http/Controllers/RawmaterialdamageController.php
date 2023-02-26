<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\Rawmaterialdamage;
use App\Http\Controllers\RawmaterialdamageController;

class RawmaterialdamageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/master/rawmaterial-damage-list');

    }

    public function getRawmaterialdamageData()
    {
        $data = Rawmaterialdamage::latest()->get(); 
        
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
                // ->addcolumn('damage_product', function($row){
                //     $damage = product::where('id', $row->damage_product)->pluck('name');
                //     return $damage[0];
                // })
                ->addColumn('action', function($row){

                        $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                       //$btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

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
        $this->validate($request, ['damage_code'=>'required','damage_date'=>'required','material_name'=>'required','damage_rate'=>'required','damage_quantity'=>'required','damage_total'=>'required']); 



        $item = Rawmaterialdamage::updateOrCreate(
                                       ['id' => $request->rawmaterialdamage_id],
                                       [
                
                                        'damage_code' => ucwords($request->damage_code),
                                        'damage_date'=>$request->damage_date,
                                        'material_name'=>$request->material_name,
                                        'damage_rate'=>$request->damage_rate,
                                        'damage_quantity'=>ucwords($request->damage_quantity),
                                        'damage_total'=>$request->damage_total,
                                        'note'=>$request->note,
                                     ]
        );

        if($request->rawmaterialdamage_id){
            $msg = "Product Damage Entry Updated Successfully.";
        }
        else{
            $msg = "Product Damage Entry Created Successfully.";
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
        $data = Rawmaterialdamage::find($id);
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
        $del = Rawmaterialdamage::find($id)->delete();
        return response()->json(['success'=>'Product Damage Entry deleted successfully.']);
    }
}
