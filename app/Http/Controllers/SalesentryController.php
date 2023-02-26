<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Customer; 
use App\Models\Salesentry;
use App\Models\Orderdetail;
use Illuminate\Http\Request;

class SalesentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cust=Customer::get()->pluck( 'cust_name','id')->toArray();   

        // $id=Orderdetail::get()->pluck('customer_id')->toArray();
        // $cust_name=Customer::where('id',$id)->pluck('firstname')->toArray();
        // $cust_num=Customer::where('id',$id)->pluck('phone')->toArray();
        // $cust_add=Customer::where('id',$id)->pluck('address')->toArray();
        return view('backend/master/salesentry-list',compact('cust'));
    }

    public function getSalesentryData()
    {
        $data = Salesentry::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name')->toArray();
                    return $icon;
                })    
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){
                   
                        $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct d-none"><i class="ion-edit"></i></a></abbr>';

                        $ord= Orderdetail::where('ord_id',$row->id)->pluck('ord_id');
                        $inv= Order::where('ord_id',$row->id)->pluck('invoice_num')->toarray();
                        if(count($ord)>0){
                            if(count($inv)==0){
                            $btn = $btn.' <abbr title="Edit Order"><a href='.url('orderdetail/'.base64_encode($row->id).'').' data-toggle="tooltip"  data-original-title="Order Detail" class="btn btn-secondary btn-sm"><i class="ion-edit"></i></a></abbr>';
                            }
                            else{
                            $btn = $btn.' <abbr title="View Invoice"><a href='.url('salesinvoice/'.base64_encode($row->id).'').' data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View Invoice" class="btn btn-secondary btn-sm viewInvoice"><i class="zmdi zmdi-receipt"></i></a></abbr>';
                            }         
                            
                            $btn = $btn.' <abbr title="View order details"><a data-id="'.$row->id.'" data-toggle="tooltip"  data-original-title="View order details" class="btn btn-primary btn-sm viewProduct"><i class="zmdi zmdi-eye"></i></a></abbr>'; 
                        }

                        else{
                            $btn = $btn.' <abbr title="Add Order"><a href='.url('orderdetail/'.base64_encode($row->id).'').' data-toggle="tooltip"  data-original-title="Order Detail" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a></abbr>';
                        }
                        
                        $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                      
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }


    public function getOrderdetailData($id)
    {
        // dd($id);
        $data = Orderdetail::latest()->where('ord_id', $id)->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name')->toArray(); 
                    return $icon;
                }) 
                ->addColumn('customer_num', function($row){
                    $icon= Customer::where('id' , $row->customer_num)->pluck('phone')->toArray(); 
                    return $icon;
                })  
                ->addColumn('customer_add', function($row){
                    $icon= Customer::where('id' , $row->customer_add)->pluck('address')->toArray(); 
                    return $icon;
                }) 
                ->addColumn('product_id', function($row){
                    $icon= Product::where('id' , $row->product_id)->pluck('name')->toArray(); 
                    return $icon;
                }) 
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                       $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editProduct"><i class="bx bx-edit"></i></a>';

                    //    $btn = $btn.' <abbr title="Order Detail"><a href='.url('orderdetail/'.base64_encode($row->customer_id).'').' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a></abbr>';

                       $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="bx bx-trash"></i></a>';

                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function getCustomerType(Request $request)
    {
        $data = Customer::find($request->customer_id);
        return response()->json(['type'=>$data['cust_type']]);
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

    public function customerdata($id)
    {
        $data = Orderdetail::where('ord_id',$id)->pluck('customer_id')->toArray();
        $cust_name= Customer::where('id', $data[0])->pluck('cust_name')->toArray();
        $cust_phone= Customer::where('id', $data[0])->pluck('phone')->toArray();
        $cust_address= Customer::where('id', $data[0])->pluck('address')->toArray();
        $name=$cust_name[0];
        $phone=$cust_phone[0];
        $address=$cust_address[0];
        return response()->json(["name"=>$name,"phone"=>$phone,"address"=>$address]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['customer_id'=>'required','customer_type'=>'required']); 
        


        Salesentry::updateOrCreate(
                                    ['id' => $request->salesentry_id],
                                    [
                                        'customer_id'=>$request->customer_id,
                                        'customer_type'=>$request->customer_type,
                                    ]
                                );        
        if($request->salesentry_id){
            $msg = "Customer Updated Successfully.";
        }
        else{
            $msg = "Customer Created Successfully.";
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
        $data = Salesentry::find($id);
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
        $del = Salesentry::find($id)->delete();
        return response()->json(['success'=>'Sales Deleted Successfully.']);
    }
}
