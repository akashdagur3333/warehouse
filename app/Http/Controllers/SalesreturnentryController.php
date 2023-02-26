<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Salesentry;
use Illuminate\Http\Request;
use App\Models\Productnameentry;
use App\Models\Salesreturnentry;
use App\Http\Controllers\SalesreturnentryController;

class SalesreturnentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Productnameentry::get()->pluck('product_entry','id')->toArray();
        $customer_name=Customer::get()->pluck('cust_name','id')->toArray();
        // $invoice_num=Order::whereIn('customer_id',$cust)->pluck('invoice_num')->toArray();

        return view('backend/master/sales-return-entry',compact('customer_name','product'));
    }

    public function getSalesreturnentryData()
    {

        $data = Salesreturnentry::latest()->get(); 
        
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
                ->addColumn('customer_name', function($row){
                    $sup= Customer::where('id', $row->customer_name)->pluck('cust_name')->toArray();
                    return $sup;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
    }
  

    // public function getCustomerInvoice(Request $request)
    // {
    //     $data = Order::find(2);
    //     dd($data);
    //     return response()->json(['invoice_num'=>$data['invoice_num']]);
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
        $this->validate($request, ['sales_invoice'=>'required','customer_name'=>'required','return_date'=>'required','customer_mobile'=>'required','customer_address'=>'required','product'=>'required','return_rate'=>'required','quantity'=>'required','total'=>'required']); 
        
        


        $item = Salesreturnentry::updateOrCreate(
                                    ['id' => $request->salesreturnentry_id],
                                    [
                                        'sales_invoice' => $request->sales_invoice,
                                        'customer_name'=>$request->customer_name,
                                        'return_date'=>$request->return_date,
                                        'customer_mobile'=>$request->customer_mobile,
                                        'customer_address'=>$request->customer_address,
                                        'product'=>$request->product,
                                        'return_rate'=>$request->return_rate,
                                        'quantity'=>$request->quantity,
                                        'total'=>$request->total  
                                    ]
                                );  
        //var_dump($item['id']);      
        if($request->salesreturnentry_id){
            $msg = "Purchase Updated Successfully.";
            
        }
        else{
            $msg = "Purchase Created Successfully.";
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

    public function getCustomerDetail(Request $request)
    {
        $id=$request->id;
        $data = Customer::find($id);
        // $sup = Customer::find($data['supplier_name']);
       

        return response()->json(['name'=>$data['customer_name'],'address'=>$data['customer_address'],'mobile' => $data['customer_mobile']]);
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = Salesreturnentry::find($id);
        // return response()->json($data);
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
        $del = Salesreturnentry::find($id)->delete();
        return response()->json(['success'=>'Purchase deleted successfully.']);
    }
}
