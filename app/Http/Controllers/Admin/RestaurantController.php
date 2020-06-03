<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use App\Models\RestaurantMenu;
use App\Models\Category;
use App\Models\RestaurantMenuOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use DataTables;
use Image;

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
                ->addColumn('action', function ($row) {
                    return '<a href="/admin/restaurant/' . $row->id . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
							           <a href="/admin/restaurant-menu/' . $row->id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
									   <button class="btn btn-xs btn-delete" data-remote="javascript:void(0)"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $restaurantData = Restaurant::latest()->paginate(1);
        return view('pages.admin.restaurant.index', ['restaurantData' => $restaurantData ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.restaurant.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required|mimes:jpg.png,jpeg|max:2048',
            'isopen' => 'required',
            'addr1'  => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'isfeatured'=> 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('restaurant.create'))->withInput()->withErrors($validator);
        }

        $file = $request->file('logo');
		if($file){
		$fileName = time().'.'.$file->getClientOriginalExtension();

		$destinationPaththumb = 'uploads/logos/thumbnail';
		$img = Image::make($file->getRealPath());
        $img->resize(150, 90, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPaththumb.'/'.$fileName);

		$destinationPathfull = 'uploads/logos/full';
		$file->move($destinationPathfull,$fileName);
		}else{
			$fileName ="n/a";
        }

        // $file = $request->file('logo');
        // $fileName = time() . '.' . $file->getClientOriginalExtension();
        // $destinationPath = 'uploads';
        // $file->move($destinationPath, $fileName);

        $openinghour = $request->post('openinghour');
        $closinghour = $request->post('closinghour');
        $categories = $request->post('categories');
        //dd($categories);
        $categories = json_encode($categories);

        $Restaurant = new Restaurant;
        $Restaurant->name = $request->post('name');
        $Restaurant->logo = $fileName;
        $Restaurant->timings = $openinghour . " - " . $closinghour;
        $Restaurant->isopen = $request->post('isopen');
        $Restaurant->shortdescription = $request->post('shortdescription');
        $Restaurant->description = $request->post('description');
        $Restaurant->addr1 = $request->post('addr1');
        $Restaurant->addr2 = $request->post('addr2');
        $Restaurant->city = $request->post('city');
        $Restaurant->state = $request->post('state');
        $Restaurant->postcode = $request->post('postcode');
        $Restaurant->country = $request->post('country');
        $Restaurant->phone = $request->post('phone');
        $Restaurant->isfeatured = $request->post('isfeatured');
        $Restaurant->categories = $categories;
        $Restaurant->email = $request->post('email');
        $Restaurant->gmap = $request->post('gmap');

        $Restaurant->save();
        $request->session()->flash('success', 'Restaurant Menu added successfully');

        $categories = Category::all();
        return view('pages.admin.restaurant.create',compact('categories'));
    }

    public function show($id)
    {
        $data = Restaurant::find($id);
        return view('pages.admin.restaurant.show', compact('data'));
    }

    public function createmenu($id)
    {
        $id= $id;
        $categories = Category::all();
        //dd($categories);
        return view('pages.admin.restaurant.menucreate', compact('id','categories'));
    }

    public function addmenu(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
            'price' => 'required',
            'dishname' => 'required',
            'image' => 'required|mimes:jpg.png,jpeg|max:2048',
            'category' => 'required',
        ]);
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = 'uploads';
        $file->move($destinationPath, $fileName);

        $itemoptions = $request->post('itemoption');
        $itemoption = json_encode($itemoptions);

        $RestaurantMenu = new RestaurantMenu;
        $RestaurantMenu->restaurant_id = $request->post('restaurant_id');
        $RestaurantMenu->dishname = $request->post('dishname');
        $RestaurantMenu->image = $fileName;
        $RestaurantMenu->category = $request->post('category');
        $RestaurantMenu->status = '1';
        $RestaurantMenu->price = $request->post('price');
        $RestaurantMenu->itemoption = $itemoption;

        if ($RestaurantMenu->save()) {
            $restaurantOptions = $request->get('option');

            if (!empty($restaurantOptions)) {
                foreach ($restaurantOptions as $restaurantOption) {
                    $restaurantOptionObj = new RestaurantMenuOption;
                    $restaurantOptionObj->restaurant_menu_id = $RestaurantMenu->id;
                    $restaurantOptionObj->name = $restaurantOption['item'];
                    $restaurantOptionObj->price = $restaurantOption['price'];
                    $restaurantOptionObj->save();
                }
            }
        }
        //$request->session()->flash('success', 'Restaurant Menu added successfully');
        //return view('pages.admin.restaurant.menucreate')->with('id', $request->post('restaurant_id'));

        return redirect()->route('restaurantmenu', [$request->post('restaurant_id')])
            ->with('success', 'Restaurant Menu added successfull');
    }
}
