<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Quotationorder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Quotationdetail;
use Illuminate\Http\Request;

class QuotationinvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id=base64_decode($id); 

        $cust=Quotationorder::where('ord_id',$id)->pluck('customer_id')->toArray();
        $cust_id=Customer::where('id',$cust)->pluck('cust_code')->toArray(); 
        $cust_name=Customer::where('id',$cust)->pluck('cust_name')->toArray();
        $cust_institution=Customer::where('id',$cust)->pluck('institution')->toArray();
        $cust_add=Customer::where('id',$cust)->pluck('address')->toArray();
        $cust_num=Customer::where('id',$cust)->pluck('phone')->toArray();

        $emp=Quotationorder::where('ord_id',$id)->pluck('sales_by')->toArray();
        $emp_name=Employee::where('id',$emp)->pluck('name')->toArray();

        $invoice_num=Quotationorder::where('ord_id',$id)->pluck('invoice_num')->toArray();
        $sale_date=Quotationorder::where('ord_id',$id)->pluck('sales_date')->toArray();
        $sub_total=Quotationorder::where('ord_id',$id)->pluck('sub_total')->toArray();
        $transport_cost=Quotationorder::where('ord_id',$id)->pluck('transport_cost')->toArray();
        $vat=Quotationorder::where('ord_id',$id)->pluck('vat_tk')->toArray();
        $discount=Quotationorder::where('ord_id',$id)->pluck('discount_tk')->toArray();
        $total=Quotationorder::where('ord_id',$id)->pluck('total')->toArray();
        // $paid=Quotationorder::where('ord_id',$id)->pluck('paid')->toArray();
        // $due=Quotationorder::where('ord_id',$id)->pluck('due')->toArray();

        return view('backend/master/quotationinvoice-list',compact('id','cust','cust_name','cust_id','cust_add','cust_num','emp','emp_name','invoice_num','sale_date','sub_total','transport_cost','vat','discount','total','cust_institution'));
    }

    public function getQuotationorderinvoiceData($id)
    {
        // dd($id);
        $data = Quotationdetail::latest()->where('ord_id', $id)->get(); 
        
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
