<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Vendor;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Vendortransactionentry;
use App\Http\Controllers\VendortransactionentryController;

class VendortransactionentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier_name =  Vendor::get()->pluck( 'company','id')->toArray(); 
        return view('backend/master/vendor-transaction-entry',compact('supplier_name'));
    }



    public function getVendortransactionentryData()
    {
        $data = Vendortransactionentry::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                     ->addColumn('supplier_name', function($row){
                        $sup= Vendor::where('id', $row->supplier_name)->pluck('company');
                        //dd($sta);
                        return $sup[0];
                    })
                   
                ->addColumn('action', function($row){

                    $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                    $btn = $btn.' <abbr title="Delete"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a></abbr>';

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
        $this->validate($request, ['purchase_date'=>'required','supplier_name'=>'required']); 
        
        


        $item = Vendortransactionentry::updateOrCreate(
                                    ['id' => $request->vendortransactionentry_id],
                                    [
                                        'purchase_date'=>$request->purchase_date,
                                        'supplier_name'=>$request->supplier_name,
                                        'transaction_id'=>$request->transaction_id,
                                        'transaction_type'=>$request->transaction_type,
                                        'transaction_method'=>$request->transaction_method,
                                        'note'=>$request->note,
                                        'amount'=>$request->amount,
                                    
                                        
                                    ]
                                );  
        //var_dump($item['id']);      
        if($request->vendortransactionentry_id){
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Vendortransactionentry::find($id);
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
        $del = Vendortransactionentry::find($id)->delete();
        return response()->json(['success'=>'Supplier deleted successfully.']);
    }
}
