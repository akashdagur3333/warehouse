<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\CustomerTrait;
use App\Models\Productdamageentry;
use App\Http\Controllers\ProductdamageentryController;
use App\Models\Productnameentry;

class ProductdamageentryController extends Controller
{
    use CustomerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Productnameentry::get()->pluck('product_entry','id')->toArray();
        return view('backend/master/productdamageentry-list', compact('products'));
    }

    public function getProductdamageentryData()
    {
        $data = Productdamageentry::latest()->get(); 
        
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
                ->addcolumn('damage_product', function($row){
                    $damage = productnameentry::where('id', $row->damage_product)->pluck('product_entry')->toArray();
                    return $damage;
                })
                ->addColumn('action', function($row){

                        // $btn = '<abbr title="Edit"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-secondary btn-sm editProduct"><i class="ion-edit"></i></a></abbr>';

                       //$btn = $btn.' <a href='.url('product/create/'.$row->id).' data-toggle="tooltip"  data-original-title="Add Product" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></a>';

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
        $this->validate($request, ['damage_product'=>'required','damage_rate'=>'required','damage_quantity'=>'required','damage_total'=>'required','note'=>'required','damage_date'=>'required']); 



         Productdamageentry::updateOrCreate(
                                       ['id' => $request->productdamageentry_id],
                                       [
                                        'damage_product' => ucwords($request->damage_product),
                                        'damage_rate'=>$request->damage_rate,
                                        'damage_quantity'=>$request->damage_quantity,
                                        'damage_total'=>$request->damage_total,
                                        'note'=>ucwords($request->note),
                                        'damage_date'=>$request->damage_date,
                                     ]
        );
        // if(!$request->productdamageentry_id) {
        // $data['productdamage_code'] = $this->productdamageid_generator(); 
        //      }
                                                                                                                            
        //  Productdamageentry::updateOrCreate(['id' => $request->productdamageentry_id], $data);  

        if($request->productdamageentry_id){
            $msg = "Product Damage Entry Updated Successfully.";
        }
        else{
            $msg = "Product Damage Entry Created Successfully.";
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
        $data = Productdamageentry::find($id);
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
        $del = Productdamageentry::find($id)->delete();
        return response()->json(['success'=>'Product Damage Entry deleted successfully.']);
    }
}
