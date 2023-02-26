<?php

namespace App\Http\Controllers;

use Auth;

use DataTables;
use App\Models\State;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;

use App\Http\Traits\CustomerTrait;

class CustomerController extends Controller
{
    use CustomerTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employee::get()->pluck( 'name','id')->toArray();
        $states=State::where('status',1)->pluck('state_name','id')->toarray();
        return view('backend/master/customer-list',compact('states','employees'));
    }
    public function getCustomerData()
    {
        $data = Customer::latest()->get(); 
    
        return Datatables::of($data)
                ->addIndexColumn()
                ->editcolumn('stateind',function($row){
                    if(!is_null($row->statein)){
                 return $row->statein->state_name;
               }
                else{
                 return "empty";
                         }
                  })
                  ->addcolumn('choose_employee',function($row){
                    $emp=Employee::where('id',$row->choose_employee)->pluck('name')->toArray();
                    return $emp;
                  })
                  
                  ->addColumn('cust_type', function($row){
                    if ($row->cust_type == 1){
                        return 'Retail';
                    }
                    else{
                        return 'Whole Sale';
                    } 
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
                ->rawColumns(['action'])
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
     * Store a newly created resorce in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['cust_code'=>'required', 'cust_name'=>'required', 'institution'=>'required', 'phone'=>'required', 'address'=>'required',  'country'=>'required', 'state'=>'required', 'choose_employee'=>'required', 'previous_due'=>'required', 'credit_limit'=>'required','cust_type'=>'required']); 
        
        Customer::updateOrCreate(
            ['id' => $request->customer_id],
                                    [
                                        'cust_code' => ucwords($request->cust_code),
                                        'cust_name' => ucwords($request->cust_name), 
                                        'institution' => $request->institution, 
                                        'phone' => $request->phone, 
                                        'address' => ucwords($request->address), 
                                        'country' => ucwords($request->country), 
                                        'state' => $request->state, 
                                        'choose_employee' => $request->choose_employee, 
                                        'previous_due' => $request->previous_due, 
                                        'credit_limit' => $request->credit_limit, 
                                        'cust_type' => $request->cust_type,  
                                    ]
                                ); 
        // if(!$request->customer_id) {
        // $data['cust_code'] = $this->id_generator(); 
        //  }
                                                                                            
        // Customer::updateOrCreate(['id' => $request->customer_id], $data);                             
                                        
        if($request->customer_id){
            $msg = "Customer Updated Successfully.";
        }
        else{
            $msg = "Customer Created SuccessSuccessfullyully.";
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
        $data = Customer::find($id);
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
        $del = Customer::find($id)->delete();
        return response()->json(['success'=>'Customer deleted successfully.']);
    }


}