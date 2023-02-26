<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Rawmaterial;
use Illuminate\Http\Request;
use App\Models\Purchasereturnentry;
use App\Models\Rawmaterialnameentry;

class PurchasereturnentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $purchase_invoice = Purchase::get()->pluck('invoice_no','id')->toArray(); 
        return view('backend/master/purchase-return-entry',compact('purchase_invoice'));
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
    public function getPurchasereturnentryData()
    {

        $data = Purchasereturnentry::latest()->get(); 
        
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
                // ->addColumn('supplier_name', function($row){
                //     $sup= Vendor::where('id', $row->supplier_name)->pluck('company')->toArray();
                //     return $sup;
                // })
                ->rawColumns(['status', 'action'])
                ->make(true);
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    


    public function store(Request $request)
    {
        $this->validate($request, ['purchase_invoice'=>'required','supplier_name'=>'required','return_date'=>'required','supplier_mobile'=>'required','supplier_address'=>'required','product'=>'required','return_rate'=>'required','quantity'=>'required','total'=>'required']); 
        
        


        $item = Purchasereturnentry::updateOrCreate(
                                    ['id' => $request->purchasereturnentry_id],
                                    [
                                        'purchase_invoice' => $request->purchase_invoice,
                                        'supplier_name'=>$request->supplier_name,
                                        'return_date'=>$request->return_date,
                                        'supplier_mobile'=>$request->supplier_mobile,
                                        'supplier_address'=>$request->supplier_address,
                                        'product'=>$request->product,
                                        'return_rate'=>$request->return_rate,
                                        'quantity'=>$request->quantity,
                                        'total'=>$request->total  
                                    ]
                                );  
        //var_dump($item['id']);      
        if($request->purchasereturnentry_id){
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

    public function getSuplireDetail(Request $request)
    {
        $id=$request->id;
        $data = Purchase::find($id);
        $sup = Vendor::find($data['supplier_name']);
        $pro = Rawmaterialnameentry::find($data['product']);
       

        return response()->json(['name'=>$sup['company'],'address'=>$data['supplier_address'],'mobile' => $data['supplier_mobile'],'product'=>$pro['material_entry'],'rate'=>$data['purchase_rate']]);
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
        $del = Purchasereturnentry::find($id)->delete();
        return response()->json(['success'=>'Purchase deleted successfully.']);
    }
}
