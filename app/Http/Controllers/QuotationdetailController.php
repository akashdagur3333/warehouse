<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Customer; 
use App\Models\Quotationentry;
use App\Models\Quotationdetail;
use Illuminate\Http\Request;

class QuotationdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id=base64_decode($id);
        $inv='QUOT-'.$id;       
            
        
        $cust_id= Quotationentry::where('id', $id)->pluck('customer_id')->toArray();
        $cust= Customer::where('id', $cust_id[0])->pluck('cust_name','id')->toArray();
        $cust_num = Customer::where('id',$cust_id[0])->pluck('phone','id')->toArray();
        $cust_add = Customer::where('id',$cust_id[0])->pluck('address','id')->toArray();
        //$custid = Createorder::get()->pluck('customer_id','id')->toArray();
        $prod =Product::get()->pluck('name','id')->toArray();
        $emp =Employee::get()->pluck('name','id')->toArray(); 
        return view('backend/master/quotationdetail-list',compact('prod','cust','id','cust_num','cust_add','emp','inv'));
    }

    public function getQuotationdetailData($id)
    {
        //dd($id);
        $data = Quotationdetail::latest()->where('ord_id', $id)->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name')->toArray();
                    // dd($icon[0]);
                    return $icon;
                })  
                ->addColumn('customer_num', function($row){
                    $icon1= Customer::where('id' , $row->customer_num)->pluck('phone')->toArray();
                    // dd($icon[0]);
                    return $icon1;
                })  
                ->addColumn('customer_add', function($row){
                    $icon2= Customer::where('id' , $row->customer_add)->pluck('address')->toArray();
                    // dd($icon[0]);
                    return $icon2;
                })  
                ->addColumn('product_id', function($row){
                    $icon3= Product::where('id' , $row->product_id)->pluck('name')->toArray();
                    // dd($icon[0]);
                    return $icon3;
                })
                // ->addColumn('sales_by', function($row){
                //     $icon= Employee::where('id' , $row->sales_by)->pluck('name');
                //     // dd($icon[0]);
                //     return $icon[0];
                // })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                    $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                    //    $btn = $btn.' <abbr title="Order Detail"><a href='.url('orderdetail/'.base64_encode($row->customer_id).'').' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a></abbr>';

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['total_amount'=>'required','product_id'=>'required','mrp'=>'required','tax_id'=>'required','quantity'=>'required']); 
        


        Quotationdetail::updateOrCreate(
                                    ['id' => $request->quotationdetail_id],
                                    [                           
                                        'ord_id'=>$request->ord_id,             
                                        'customer_id'=>$request->customer_id,
                                        'customer_num'=>$request->customer_num,
                                        'customer_add'=>$request->customer_add, 
                                        'product_id'=>$request->product_id, 
                                        'mrp'=>$request->mrp,
                                        'quantity'=>$request->quantity,
                                        'tax_id'=>$request->tax_id,
                                        'total_amount'=>$request->total_amount,                                  
                                    ]
                                );        
        if($request->quotationdetail_id){
            $msg = "Order Updated Successfully.";
        }
        else{
            $msg = "Order Added Successfully. Please Fill Account Details.";
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
        $data = Quotationdetail::find($id);
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
        $del = Quotationdetail::find($id)->delete();
        return response()->json(['success'=>'Order deleted successfully.']);
    }
}
