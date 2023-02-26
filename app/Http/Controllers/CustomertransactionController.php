<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Customertransaction;


use Auth;
use DataTables;

use App\Http\Traits\CustomerTrait;

class CustomertransactionController extends Controller
{

    use CustomerTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $customers=Customer::get()->pluck('cust_name','cust_name')->toArray();
        $institutions=Customer::get()->pluck('institution','institution')->toArray();
        return view('backend/master/customertransaction-list',compact('customers','institutions'));
    }
    public function getCustomertransactionData()
    {
        $data = Customertransaction::latest()->get(); 
        
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
                ->addColumn('action', function($row){

                    
                    $btn = ' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';
                 
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
        $this->validate($request, ['invoice_no'=>'required', 'transaction_code'=>'required', 'customer'=>'required', 'cust_institution'=>'required', 'payment_method'=>'required', 'current_due'=>'required', 'entry_date'=>'required' , 'bankacc_name'=>'required', 'note'=>'required', 'amount'=>'required']); 
        
        


        $data =
                                   
                                    [
                                        'invoice_no'=>$request->invoice_no,
                                        'transaction_code'=>$request->transaction_code,
                                        'customer'=>$request->customer,
                                        'cust_institution'=>$request->cust_institution,
                                        'payment_method'=>$request->payment_method,
                                        'current_due'=>$request->current_due,
                                        'entry_date'=>$request->entry_date,
                                        'bankacc_name'=>$request->bankacc_name, 
                                        'note'=>$request->note, 
                                        'amount'=>$request->amount,   
                                    ];
                                 

        if(!$request->customertransaction_id) {
        $data['transaction_code'] = $this->cuspur_id_generator(); 
         }
                                                            
        Customertransaction::updateOrCreate(['id' => $request->customertransaction_id], $data);   

        if($request->customertransaction_id){
            $msg = "Customer transaction Updated Successfully.";
            
        }
        else{
            $msg = "Customer transaction Added Successfully.";
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
        $del = Customertransaction::find($id)->delete();
        return response()->json(['success'=>'Customer transaction deleted successfully.']);
    }
    
}
