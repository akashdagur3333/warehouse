<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Order;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Orderdetail;
use Illuminate\Http\Request;
use App\Models\Productnameentry;

class SalesinvoicerecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choose_invoice = Sales::get()->pluck('invoice_no','id')->toArray();
        return view('backend/master/salesinvoice-record-list',compact('choose_invoice'));
    }

    public function getInvoiceData(Request $request)
    {
        $id=$request->id; 
        $data = Sales::find($id); 
        $product = Productnameentry::find($data['product']);  
        $Customerdata = Customer::find($data['customer_name']);   
        $Employeedata = Employee::find($data['sales_by']);   

        return response()->json(['customer_institution'=>$Customerdata['institution'],'customer_name'=>$Customerdata['cust_name'],'customer_address' => $Customerdata['address'],'customer_mobile' => $Customerdata['phone'],'sales_id' => $data['id'],'invoice_no' => $data['invoice_no'],
        'sales_date' => $data['sales_date'],'total' => $data['total'],'discount_tk' => $data['discount_tk'],'vat_tk' => $data['vat_tk'], 
        'transport_cost' => $data['transport_cost'],'totalam' => $data['totalam'],'paid' => $data['paid'],'due' => $data['due'],'product' => $product['product_entry'],'sales_rate' => $data['sales_rate'],'quantity' => $data['quantity']
    ]);
    //return response()->json(['purchase_id'=>'purchase_id']);
    }

    // public function getOrderinvoiceRecordData($id)
    // {
    //     // dd($id);
    //     $data = Sales::latest()->where('sales_id', $id)->get(); 
        
    //     return Datatables::of($data)
    //             ->addIndexColumn()
                
    //             // ->addColumn('customer_id', function($row){
    //             //     $icon= Customer::where('id' , $row->customer_id)->pluck('cust_name'); 
    //             //     return $icon[0];
    //             // }) 
    //             // ->addColumn('customer_num', function($row){
    //             //     $icon= Customer::where('id' , $row->customer_num)->pluck('phone'); 
    //             //     return $icon[0];
    //             // })  
    //             // ->addColumn('customer_add', function($row){
    //             //     $icon= Customer::where('id' , $row->customer_add)->pluck('address'); 
    //             //     return $icon[0];
    //             // }) 
    //             // ->addColumn('product_id', function($row){
    //             //     $icon= Product::where('id' , $row->product_id)->pluck('name'); 
    //             //     return $icon[0];
    //             // }) 
    //             ->editColumn('updated_at', function($row){ 
    //                     return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
    //                  }) 
    //             ->addColumn('action', function($row){

    //                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editProduct"><i class="bx bx-edit"></i></a>';

    //                 //    $btn = $btn.' <abbr title="Order Detail"><a href='.url('orderdetail/'.base64_encode($row->customer_id).'').' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a></abbr>';

    //                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="bx bx-trash"></i></a>';

    //                     return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    // }


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
