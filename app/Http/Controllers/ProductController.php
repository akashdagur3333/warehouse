<?php

namespace App\Http\Controllers;

use Auth;

use DataTables;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Productnameentry;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Productnameentry::get()->pluck('product_entry','id')->toArray();
        $cat=Category::get()->pluck( 'name','id')->toArray();
        return view('backend/master/product-list', compact('cat','product'));
    }

    public function getProductData()
    {
        $data = Product::latest()->get(); 
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $name = $row->status.".png";
                    $icon = '<img src="'.asset("images")."/".$name.'">';
                    return $icon;
                })
                ->addColumn('category_id', function($row){
                    $icon= Category::where('id' , $row->category_id)->pluck('name');
                    return $icon[0];
                })
                ->addColumn('name', function($row){
                    $prod= Productnameentry::where('id', $row->name)->pluck('product_entry');
                    return $prod[0];
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
        $this->validate($request, ['status'=>'required','name'=>'required','category_id'=>'required','brand'=>'required','description'=>'required','hsn'=>'required','is_inventory'=>'required','current_quantity'=>'required']); 
        


        Product::updateOrCreate(
                                    ['id' => $request->product_id],
                                    [
                                        'name' => ucwords($request->name),
                                        'category_id'=>$request->category_id,
                                        'brand'=>ucwords($request->brand),
                                        'product_code' => ucwords($request->product_code),
                                        'product_category'=>$request->product_category,
                                        'sales_rate'=>ucwords($request->sales_rate),
                                        'description'=>ucwords($request->description),
                                        'hsn'=>ucwords($request->hsn),
                                        'is_inventory'=>ucwords($request->is_inventory),
                                        'current_quantity'=>$request->current_quantity,
                                        'status'=>$request->status,
                                    ]
                                );        
        if($request->product_id){
            $msg = "Product Updated Successfully.";
        }
        else{
            $msg = "Product Created Successfully.";
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
        $data = Product::find($id);
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
        $del = Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
