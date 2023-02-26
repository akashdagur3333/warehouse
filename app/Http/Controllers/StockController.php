<?php

namespace App\Http\Controllers;

use Auth;

use DataTables;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Productnameentry;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prod =  Productnameentry::get()->pluck( 'product_entry','id')->toArray(); 
        return view('backend/master/stock-list',compact('prod'));
    }


    public function getStocksData()
    {
        $data = Stock::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('product_id', function($row){
                    $icon= Productnameentry::where('id' , $row->product_id)->pluck('product_entry')->toArray();
                    return $icon;
                })
                ->editColumn('updated_at', function($row){ 
                        return \Carbon\Carbon::parse($row->updated_at)->diffForHumans();                     
                     }) 
                ->addColumn('action', function($row){

                        $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                       //$btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

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
        $this->validate($request, ['product_id'=>'required','product_price'=>'required','quantity'=>'required','sold'=>'required','remaining'=>'required']); 
        
        // return ($request->all());


        Stock::updateOrCreate(
                                    ['id' => $request->stock_id],
                                    [
                                        'product_id' => ucwords($request->product_id),
                                        'product_price'=>$request->product_price,
                                        'quantity'=>$request->quantity,
                                        'sold'=>$request->sold,
                                        'remaining'=>$request->remaining,
                                    ]
                                );        
        if($request->stock_id){
            $msg = "Stock Updated Successfully.";
            
        }
        else{
            $msg = "Stock Created Successfully.";
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
        $data = Stock::find($id);
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
        $del = Stock::find($id)->delete();
        return response()->json(['success'=>'Stock deleted successfully.']);
    }
}