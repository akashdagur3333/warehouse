<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;

use App\Models\State;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states=State::where('status',1)->pluck('state_name','id')->toarray();
        return view('backend/master/employees-list',compact('states'));
    }



    public function getEmployeesData()
    {
        $data = Employee::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('state', function($row){
                    $icon= State::where('id' , $row->state)->pluck('state_name');
                    // dd($icon[0]);
                    return $icon[0];
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
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
        $this->validate($request, ['name'=>'required', 'father_name'=>'required', 'mother_name'=>'required', 'gender'=>'required', 'dob'=>'required', 'blood_group'=>'required', 'marital_status'=>'required', 'phone'=>'required', 'alt_phone'=>'required', 'email'=>'required', 'aadhar'=>'required', 'religion'=>'required', 'nationality'=>'required', 'address'=>'required', 'city'=>'required', 'district'=>'required', 'state'=>'required', 'zip'=>'required', 'p_address'=>'required', 'p_city'=>'required', 'p_district'=>'required', 'p_state'=>'required', 'p_zip'=>'required', 'status'=>'required']); 
        
        Employee::updateOrCreate(
                                    ['id' => $request->employee_id],
                                    [
                                        'name' => ucwords($request->name), 
                                        'father_name' => ucwords($request->father_name), 
                                        'mother_name' => ucwords($request->mother_name), 
                                        'gender' => $request->gender, 
                                        'dob' => $request->dob, 
                                        'blood_group' => $request->blood_group, 
                                        'marital_status' => $request->marital_status, 
                                        'phone' => $request->phone, 
                                        'alt_phone' => $request->alt_phone, 
                                        'email' => $request->email, 
                                        'aadhar' => $request->aadhar, 
                                        'religion' => ucwords($request->religion), 
                                        'nationality' => ucwords($request->nationality), 
                                        'address' => ucwords($request->address), 
                                        'city' => ucwords($request->city), 
                                        'district' => ucwords($request->district), 
                                        'state' => $request->state, 
                                        'zip' => $request->zip, 
                                        'p_address' => ucwords($request->p_address), 
                                        'p_city' => ucwords($request->p_city), 
                                        'p_district' => ucwords($request->p_district), 
                                        'p_state' => $request->p_state, 
                                        'p_zip' => $request->p_zip, 
                                        'status'=> $request->status,
                                    ]
                                );        
        if($request->employee_id){
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
        $data = Employee::find($id);
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
        $del = Employee::find($id)->delete();
        return response()->json(['success'=>'Employee deleted successfully.']);
    }
}
