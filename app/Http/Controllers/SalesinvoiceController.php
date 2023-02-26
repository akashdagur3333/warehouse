<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Orderdetail;
use Illuminate\Http\Request;

class SalesinvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id=base64_decode($id); 

        $cust=Order::where('ord_id',$id)->pluck('customer_id')->toArray();
        $cust_id=Customer::where('id',$cust)->pluck('cust_code')->toArray(); 
        $cust_name=Customer::where('id',$cust)->pluck('cust_name')->toArray();
        $cust_institution=Customer::where('id',$cust)->pluck('institution')->toArray();
        $cust_add=Customer::where('id',$cust)->pluck('address')->toArray();
        $cust_num=Customer::where('id',$cust)->pluck('phone')->toArray();

        $emp=Order::where('ord_id',$id)->pluck('sales_by')->toArray();
        $emp_name=Employee::where('id',$emp)->pluck('name')->toArray();

        $invoice_num=Order::where('ord_id',$id)->pluck('invoice_num')->toArray();
        $sale_date=Order::where('ord_id',$id)->pluck('sales_date')->toArray();
        $sub_total=Order::where('ord_id',$id)->pluck('sub_total')->toArray();
        $transport_cost=Order::where('ord_id',$id)->pluck('transport_cost')->toArray();
        $vat=Order::where('ord_id',$id)->pluck('vat_tk')->toArray();
        $discount=Order::where('ord_id',$id)->pluck('discount_tk')->toArray();
        $total=Order::where('ord_id',$id)->pluck('total')->toArray();
        $paid=Order::where('ord_id',$id)->pluck('paid')->toArray();
        $due=Order::where('ord_id',$id)->pluck('due')->toArray();

        return view('backend/master/salesinvoice-list',compact('id','cust','cust_name','cust_id','cust_add','cust_num','emp','emp_name','invoice_num','sale_date','sub_total','transport_cost','vat','discount','total','paid','due','cust_institution'));
    }

    public function getOrderinvoiceData($id)
    {
        // dd($id);
        $data = Orderdetail::latest()->where('ord_id', $id)->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('customer_id', function($row){
                    $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name'); 
                    return $icon[0];
                }) 
                ->addColumn('customer_num', function($row){
                    $icon= Customer::where('id' , $row->customer_num)->pluck('phone'); 
                    return $icon[0];
                })  
                ->addColumn('customer_add', function($row){
                    $icon= Customer::where('id' , $row->customer_add)->pluck('address'); 
                    return $icon[0];
                }) 
                ->addColumn('product_id', function($row){
                    $icon= Product::where('id' , $row->product_id)->pluck('name'); 
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
        //
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
