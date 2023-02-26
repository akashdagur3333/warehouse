<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Task;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $state=State::where('status',1)->pluck('state_name','id')->toarray();
        $district=District::get()->pluck('title','id')->toarray();
        return view('backend/master/task',compact('state','district'));
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

    public function getTaskData()
    {
        $data = Task::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('status', function($row){
                //     $name = $row->status.".png";
                //     $icon = '<img src="'.asset("images")."/".$name.'">';
                //     return $icon;
                // })
                ->addColumn('state', function($row){
                    $icon= State::where('id' , $row->state)->pluck('state_name')->toArray();
                    // dd($icon[0]);
                    return $icon;
                })
                // ->addColumn('district', function($row){
                //     $icon= District::where('id' , $row->district)->pluck('district_title')->toArray();
                //     // dd($icon[0]);
                //     return $icon;
                // })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                // ->addColumn('action', function($row){

                //     $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                //     //    $btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

                //     $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                //         return $btn;
                // })
                // ->rawColumns(['status', 'action'])
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
        $this->validate($request, ['state'=>'required', 'district'=>'required']); 
        
        Task::updateOrCreate(
                                    ['id' => $request->task_id],
                                    [
                                        'state' => ucwords($request->state), 
                                        'district' => ucwords($request->district), 
                                        
                                    ]
                                );        
        if($request->task_id){
            $msg = "Employee Updated Successfully.";
        }
        else{
            $msg = "Employee Created Successfully.";
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
