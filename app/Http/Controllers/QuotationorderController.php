<?php

namespace App\Http\Controllers;

use id;
use Auth;
use DataTables;
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Quotationorder;

class QuotationorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getQuotationrecordData()
    {
    
        $data = Quotationorder::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name');
                    // dd($icon[0]);
                    return $icon[0];
                }) 
                ->addColumn('created_by', function($row){
                    $icon= User::where('id' , $row->created_by)->pluck('email');
                    // dd($icon[0]);
                    return $icon[0];
                })   
                ->addColumn('sales_by', function($row){
                    $icon= Employee::where('id' , $row->sales_by)->pluck('name');
                    // dd($icon[0]);
                    return $icon[0];
                })
                // ->editColumn('updated_at', function($row){ 
                //         return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                //      }) 
                // ->addColumn('action', function($row){

                //     $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                //     //    $btn = $btn.' <abbr title="Order Detail"><a href='.url('orderdetail/'.base64_encode($row->customer_id).'').' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a></abbr>';

                //     $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

                //         return $btn;
                // })
                ->rawColumns([])
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
        $this->validate($request, ['transport_cost'=>'required','vat_per'=>'required','vat_tk'=>'required','discount_per'=>'required','discount_tk'=>'required','total'=>'required','invoice_num'=>'required','sales_by'=>'required','sales_date'=>'required']); 
        


        Quotationorder::updateOrCreate(
                                    ['id' => $request->quotationorder_id],
                                    [                           
                                        'ord_id'=>$request->ord_id,             
                                        'customer_id'=>$request->customer_id,
                                        'customer_num'=>$request->customer_num,
                                        'customer_add'=>$request->customer_add,
                                        'invoice_num'=>$request->invoice_num, 
                                        'sales_by'=>$request->sales_by, 
                                        'sales_date'=>$request->sales_date, 
                                        'sub_total'=>$request->sub_total,
                                        'sub_quantity'=>$request->sub_quantity,
                                        'transport_cost'=>$request->transport_cost,
                                        'vat_per'=>$request->vat_per,
                                        'vat_tk'=>$request->vat_tk,
                                        'discount_per'=>$request->discount_per,                                  
                                        'discount_tk'=>$request->discount_tk,                                  
                                        'total'=>$request->total,                                   
                                    ]
                                );        
        if($request->quotationorder_id){
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
