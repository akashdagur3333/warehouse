<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dept =  Department::get()->pluck( 'title','id')->toArray(); 
        return view('backend/master/designation-list',compact('dept'));
    }



    public function getDesignationsData()
    {
        $data = Designation::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function($row){
                    $icon= Department::where('id' , $row->department)->pluck('title')->toArray();
                    // dd($icon[0]);
                    return $icon;
                })
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
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
        $this->validate($request, ['title'=>'required','department'=>'required','status'=>'required']); 
        
        // return ($request->all());


        Designation::updateOrCreate(
                                    ['id' => $request->designation_id],
                                    [
                                        'title' => ucwords($request->title),
                                        'department'=>$request->department,
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->designation_id){
            $msg = "Designation Updated Successfully.";
        }
        else{
            $msg = "Designation  Created Successfully.";
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
        $data = Designation::find($id);
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
        $del = Designation::find($id)->delete();
        return response()->json(['success'=>'Designation deleted successfully.']);
    }
}