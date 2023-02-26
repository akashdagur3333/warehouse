<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Createorder;
use App\Models\Orderdetail;
use Illuminate\Http\Request;

class CreateorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cust=Customer::get()->pluck( 'firstname','id')->toArray();
        return view('backend/master/createorder-list',compact('cust'));
    }

    public function getCreateorderData()
    {
        $data = Createorder::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('firstname');
                    // dd($icon[0]);
                    return $icon[0];
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){
                   
                        $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct d-none"><i class="ion-edit"></i></a></abbr>';

                       $btn = $btn.' <abbr title="Order Detail"><a href='.url('orderdetail/'.base64_encode($row->id).'').' data-toggle="tooltip"  data-original-title="Order Detail" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a></abbr>';

                       $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                       $ord= Orderdetail::where('ord_id',$row->id)->pluck('ord_id');
                        if(count($ord)>0){
                            
                        $btn = $btn.' <abbr title="View order details"><a data-id="'.$row->id.'" data-toggle="tooltip"  data-original-title="View order details" class="btn btn-primary btn-sm viewProduct"><i class="zmdi zmdi-eye"></i></a></abbr>';
                        }
                      
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
                    $icon= Customer::where('id' , $row->customer_id)->pluck('firstname');
                    // dd($icon[0]);
                    return $icon[0];
                })
                ->addColumn('product_id', function($row){
                    $icon= Product::where('id' , $row->product_id)->pluck('name');
                    // dd($icon[0]);
                    return $icon[0];
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
        $this->validate($request, ['customer_id'=>'required']); 
        


        Createorder::updateOrCreate(
                                    ['id' => $request->createorder_id],
                                    [
                                        'customer_id'=>$request->customer_id,
                                        
                                    ]
                                );        
        if($request->createorder_id){
            $msg = "Order Updated Successfully.";
        }
        else{
            $msg = "Order Created Successfully.";
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
        $data = Createorder::find($id);
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
        $del = Createorder::find($id)->delete();
        return response()->json(['success'=>'Order deleted successfully.']);
    }
}
