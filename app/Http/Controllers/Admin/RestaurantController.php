<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use DataTables;

class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
		if ($request->ajax()) {
            $data = Restaurant::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){   
                            return '<a href="/admin/restaurant/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
							           <a href="/admin/restaurant-menu/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
									   <button class="btn btn-xs btn-delete" data-remote="javascript:void(0)"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        } 
        return view('pages.admin.restaurant.index');
    }
	
	 public function create()
    {
        return view('pages.admin.restaurant.create');
    }
	 public function store(Request $request)
    {
		   $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'logo' =>'required|mimes:jpg.png,jpeg|max:2048',
            'timings' => 'required',
            'isopen'=>'required',
        ]);
		
		$file = $request->file('logo');
		$fileName = time().'.'.$file->getClientOriginalExtension();
		$destinationPath = 'uploads';
        $file->move($destinationPath,$fileName);
		
		$openinghour = $request->post('openinghour');
		$closinghour = $request->post('closinghour');		
		
		$Restaurant = new Restaurant;
        $Restaurant->name = $request->post('name');       
        $Restaurant->logo = $fileName;
		$Restaurant->timings = $openinghour." - ".$closinghour;
        $Restaurant->isopen =$request->post('isopen');
        $Restaurant->shortdescription = $request->post('shortdescription');
        $Restaurant->description =$request->post('description');
        
        
       $Restaurant->save();
       $request->session()->flash('success', 'Restaurant Menu added successfully');
		
        return view('pages.admin.restaurant.create');
    }
     public function show($id){
		$data = Restaurant::find($id);
       return view('pages.admin.restaurant.show', compact('data'));
	}
	
    public function createmenu($id){
        return view('pages.admin.restaurant.menucreate')->with('id',$id);
    }

    public function addmenu(Request $request){
		$validator = Validator::make($request->all(), [ 
            'restaurant_id' => 'required',
			'price'=>'required',
            'dishname' => 'required',
            'image' => 'required|mimes:jpg.png,jpeg|max:2048',
            'category'=>'required',
        ]);
		$file = $request->file('image');
		$fileName = time().'.'.$file->getClientOriginalExtension();
		$destinationPath = 'uploads';
        $file->move($destinationPath,$fileName);
		
	   $itemoptions = $request->post('itemoption');
	   $itemoption = json_encode($itemoptions);
		
        $RestaurantMenu = new RestaurantMenu;
        $RestaurantMenu->restaurant_id = $request->post('restaurant_id');
        $RestaurantMenu->dishname = $request->post('dishname');
        $RestaurantMenu->image = $fileName;
        $RestaurantMenu->category =$request->post('category');
        $RestaurantMenu->status = '1';
		$RestaurantMenu->price =$request->post('price');
		$RestaurantMenu->itemoption = $itemoption;		
        
       $RestaurantMenu->save();
       $request->session()->flash('success', 'Restaurant Menu added successfully');
        return view('pages.admin.restaurant.menucreate')->with('id',$request->post('restaurant_id'));
    }
}
