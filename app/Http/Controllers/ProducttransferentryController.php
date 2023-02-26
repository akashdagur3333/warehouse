<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Productnameentry;
use App\Models\Producttransferentry;
use App\Http\Controllers\ProducttransferentryController;

class ProducttransferentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Productnameentry::get()->pluck('product_entry','id')->toArray();
        $transfer_by = Employee::get()->pluck('name','id')->toArray();
        return view('backend/master/product-transfer-entry',compact('product','transfer_by'));
    }

    public function getProducttransferentryData()
    {

        $data = Producttransferentry::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addcolumn('transfer_by', function($row){
                    $transfer = Employee::where('id',$row->transfer_by)->pluck('name')->toArray();
                    return $transfer;
                })     
                ->addcolumn('product', function($row){
                    $pro = Productnameentry::where('id',$row->product)->pluck('product_entry')->toArray();
                    return $pro;
                })   
                ->addColumn('action', function($row){

                    // $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                    $btn = ' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

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
        $this->validate($request, ['transfer_by'=>'required','product'=>'required','transfer_date'=>'required','stock'=>'required','rate'=>'required','quantity'=>'required','total'=>'required','transfer_note'=>'required']); 
        
        


        $item = Producttransferentry::updateOrCreate(
                                    ['id' => $request->producttransferentry_id],
                                    [
                                
                                        'transfer_by'=>$request->transfer_by,
                                        'product'=>$request->product,
                                        'transfer_date'=>$request->transfer_date,
                                        'stock'=>$request->stock,
                                        'rate'=>$request->rate,
                                        'quantity'=>$request->quantity,
                                        'total'=>$request->total,
                                        'transfer_note'=>$request->transfer_note,
                                    
                                        
                                        
                                    ]
                                );  
        //var_dump($item['id']);      
        if($request->producttransferentry_id){
            $msg = "Purchase Updated Successfully.";
            
        }
        else{
            $msg = "Purchase Created Successfully.";
        }
        return response()->json(['msg'=>$msg,'id' => $item['id'],
        'id' => $request->producttransferentry_id,
        'transfer_branch' => $request->transfer_branch,
        'transfer_by'=>$request->transfer_by,
        'product'=>$request->product,
        'transfer_date'=>$request->transfer_date,
        'stock'=>$request->stock,
        'rate'=>$request->rate,
        'quantity'=>$request->quantity,
        'total'=>$request->total,
        'transfer_note'=>$request->transfer_note,
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

    // public function getSuplireDetail(Request $request)
    // {
    //     $id=$request->id;
    //     $data = Vendor::find($id);
    //     // var_dump($data);

    //     return response()->json(['address'=>$data['address'],'phone' => $data['phone']]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Producttransferentry::find($id);
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
        $del = Producttransferentry::find($id)->delete();
        return response()->json(['success'=>'Transfer data deleted successfully.']);
    }
}
