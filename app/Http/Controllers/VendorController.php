<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\State;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states=State::where('status',1)->pluck('state_name','state_name')->toarray();
        return view('backend/master/vendor-entry',compact('states'));
    }

    public function getVendorsData()
    {
        $data = Vendor::latest()->with('statein')->get();  
        
        return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('status', function($row){
                //     $name = $row->status.".png";
                //     $icon = '<img src="'.asset("images")."/".$name.'">';
                //     return $icon;
                // })
                ->editcolumn('stateind',function($row){
                    if(!is_null($row->statein)){
                 return $row->statein->state_name;
               }
                else{
                 return "empty";
                         }
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
        $this->validate($request, ['company'=>'required', 'phone'=>'required', 'email'=>'required', 'address'=>'required', 'state'=>'required', 'country'=>'required', 'pincode'=>'required', 'gstin'=>'required', 'cin'=>'required', 'previous_due'=>'required']); 
        
        Vendor::updateOrCreate(
                                    ['id' => $request->vendor_id],
                                    [
                                        'company' => ucwords($request->company),
                                        'phone' => $request->phone, 
                                        'email' => $request->email,
                                        'address' => $request->address,
                                        'state' => $request->state,
                                        'country' => $request->country,
                                        'pincode' => $request->pincode,
                                        'gstin' => $request->gstin,
                                        'cin' => $request->cin,
                                        'previous_due' => $request->previous_due
                                    ]
                                );        
        if($request->vendor_id){
            $msg = "Vendor Updated Successfully.";
        }
        else{
            $msg = "Vendor Created Successfully.";
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
        $data = Vendor::find($id);
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
        $del = Vendor::find($id)->delete();
        return response()->json(['success'=>'Vendor deleted successfully.']);
    }
}
