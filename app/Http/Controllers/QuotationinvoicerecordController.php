<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Quotationorder;
use App\Models\Quotationdetail;
use App\Http\Controllers\QuotationinvoicerecordController;

class QuotationinvoicerecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choose_invoice = Quotationorder::get()->pluck('invoice_num','id')->toArray();
        return view('backend/master/quotationinvoice-record-list',compact('choose_invoice'));
    }

    public function getQuotationInvoiceData(Request $request)
    {
        $id=$request->id; 
        $data = Quotationorder::find($id);   
        $Customerdata = Customer::find($data['customer_id']);   
        $Employeedata = Employee::find($data['sales_by']);   

        return response()->json(['customer_id'=>$Customerdata['cust_code'],'customer_institution'=>$Customerdata['institution'],'customer_name'=>$Customerdata['cust_name'],'customer_address' => $Customerdata['address'],'customer_number' => $Customerdata['phone'],'ref_by' => $Employeedata['name'],'invoice_number' => $data['invoice_num'],
        'sales_date' => $data['sales_date'],'sub_total' => $data['sub_total'],'discount' => $data['discount_tk'],'total' => $data['total'],'vat' => $data['vat_tk'], 'ord_id'=> $data['ord_id'],
        'transport_cost' => $data['transport_cost'],'total' => $data['total']
    ]);
    //return response()->json(['purchase_id'=>'purchase_id']);
    }

    public function getQuotationorderinvoiceRecordData($id)
    {
        // dd($id);
        $data = Quotationdetail::latest()->where('ord_id', $id)->get(); 
        
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
