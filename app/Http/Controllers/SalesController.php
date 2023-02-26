<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use App\Models\Sales;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Productnameentry;
use App\Http\Controllers\SalesController;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::get()->pluck('name','id')->toArray();
        $customer = Customer::get()->pluck('cust_name','id')->toArray();
        $product = Productnameentry::get()->pluck('product_entry','id')->toArray();
        return view('backend/master/sales-list',compact('customer','product','employee'));

    }

    public function getSalesData()
    {

        $data = Sales::latest()->get(); 
        
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
                ->addColumn('sales_by', function($row){
                        $sup= Employee::where('id', $row->sales_by)->pluck('name')->toArray();
                        return $sup;
                    })
                    ->addColumn('customer_name', function($row){
                        $s1= Customer::where('id', $row->customer_name)->pluck('cust_name')->toArray();
                        return $s1;
                    })
                    ->addColumn('product', function($row){
                        $s2= Productnameentry::where('id', $row->product)->pluck('product_entry')->toArray();
                        return $s2;
                    })
                
                ->addColumn('action', function($row){
                    $btn = '<abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';
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
        $this->validate($request, ['invoice_no'=>'required','sales_by'=>'required','sales_date'=>'required','customer_name'=>'required','customer_mobile'=>'required','customer_address'=>'required','product'=>'required','sales_rate'=>'required','quantity'=>'required','total'=>'required']); 
        
        


        $item = Sales::updateOrCreate(
                                    ['id' => $request->sales_id],
                                    [
                                        'invoice_no' => $request->invoice_no,
                                        'sales_by'=>$request->sales_by,
                                        'sales_date'=>$request->sales_date,
                                        'customer_name'=>$request->customer_name,
                                        'customer_mobile'=>$request->customer_mobile,
                                        'customer_address'=>$request->customer_address,
                                        'product'=>$request->product,
                                        'sales_rate'=>$request->sales_rate,
                                        'quantity'=>$request->quantity,
                                        'total'=>$request->total,
                                        'vat_tk'=>$request->vat_tk,
                                        'discount_tk'=>$request->discount_tk,
                                        'transport_cost'=>$request->transport_cost,
                                        'totalam'=>$request->totalam,
                                        'paid'=>$request->paid,
                                        'due'=>$request->due,
                                        
                                        
                                    ]
                                );  
        if($request->sales_id){
            $msg = "Purchase Updated Successfully.";
            
        }
        else{
            $msg = "Purchase Created Successfully.";
        }
        return response()->json(['msg'=>$msg,'id' => $item['id'],
                                        'invoice_no' => $request->invoice_no,
                                        'sales_by'=>$request->sales_by,
                                        'sales_date'=>$request->sales_date,
                                        'customer_name'=>$request->customer_name,
                                        'customer_mobile'=>$request->customer_mobile,
                                        'customer_address'=>$request->customer_address,
                                        'product'=>$request->product,
                                        'sales_rate'=>$request->sales_rate,
                                        'quantity'=>$request->quantity,
                                        'total'=>$request->total,
                                        'vat_tk'=>$request->vat_tk,
                                        'discount_tk'=>$request->discount_tk,
                                        'transport_cost'=>$request->transport_cost,
                                        'totalam'=>$request->totalam,
                                        'paid'=>$request->paid,
                                        'due'=>$request->due,
    ]);
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
    public function getSuplireDetail(Request $request)
    {
        $id=$request->id;
        $data = Customer::find($id);

        return response()->json(['address'=>$data['address'],'phone' => $data['phone']]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Sales::find($id);
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
        $del = Sales::find($id)->delete();
        return response()->json(['success'=>'Purchase deleted successfully.']);
    }
}
