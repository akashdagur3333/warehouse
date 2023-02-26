<?php

namespace App\Http\Controllers;


use Auth;
use DataTables;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Purchase;
use App\Models\Rawmaterial;
use App\Models\Purchaseitem;
use Illuminate\Http\Request;
use App\Models\Purchasevendor;
use App\Models\Rawmaterialnameentry;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   
    { 
        $purchase_by =  Employee::get()->pluck( 'name','name')->toArray(); 
        $supplier_name =  Vendor::get()->pluck( 'company','id')->toArray(); 
        $product =  Rawmaterialnameentry::get()->pluck( 'material_entry','id')->toArray(); 
        $invoice=Purchase::where('id')->pluck('invoice_no')->toArray();
           return view('backend/master/purchase-list',compact('purchase_by','supplier_name','product','invoice'));
    }

    public function getPurchaseData($id)
    {

        $data = Purchase::latest()->get(); 
        
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
                ->addColumn('supplier_name', function($row){
                        $sup= Vendor::where('id', $row->supplier_name)->pluck('company')->toArray();
                        return $sup;
                    })
                    ->addColumn('product', function($row){
                        $sup= Rawmaterialnameentry::where('id', $row->product)->pluck('material_entry')->toArray();
                        return $sup;
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
    { $this->validate($request, ['invoice_no'=>'required','purchase_by'=>'required','purchase_date'=>'required','supplier_name'=>'required','supplier_mobile'=>'required','supplier_address'=>'required','product'=>'required','purchase_rate'=>'required','quantity'=>'required','total'=>'required']); 
        
        


        $item = Purchase::updateOrCreate(
                                    ['id' => $request->purchase_id],
                                    [
                                        'invoice_no' => $request->invoice_no,
                                        'purchase_by'=>$request->purchase_by,
                                        'purchase_date'=>$request->purchase_date,
                                        'supplier_name'=>$request->supplier_name,
                                        'supplier_mobile'=>$request->supplier_mobile,
                                        'supplier_address'=>$request->supplier_address,
                                        'product'=>$request->product,
                                        'purchase_rate'=>$request->purchase_rate,
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
        if($request->purchase_id){
            $msg = "Purchase Updated Successfully.";
            
        }
        else{
            $msg = "Purchase Created Successfully.";
        }
        return response()->json(['msg'=>$msg,'id' => $item['id'],
        'invoice_no' => $request->invoice_no,
        'purchase_by'=>$request->purchase_by,
        'purchase_date'=>$request->purchase_date,
        'supplier_name'=>$request->supplier_name,
        'supplier_mobile'=>$request->supplier_mobile,
        'supplier_address'=>$request->supplier_address,
        'product'=>$request->product,
        'purchase_rate'=>$request->purchase_rate,
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
        $data = Vendor::find($id);

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
        $data = Purchase::find($id);
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
    {  $del = Purchase::find($id)->delete();
        return response()->json(['success'=>'Purchase deleted successfully.']);
    }
}