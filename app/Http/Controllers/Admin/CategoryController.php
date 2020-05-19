<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use DataTables;
use Image;

class CategoryController extends Controller
{
	public function index(Request $request)
    {
		if ($request->ajax()) {
            $data = Restaurant::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){   
                            return '<a href="/admin/category/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
									   <button class="btn btn-xs btn-delete" data-remote="javascript:void(0)"><i class="fa fa-trash"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        } 
        return view('pages.admin.category.index');
    }
	
	 public function create()
    {
        return view('pages.admin.category.create');
    }
	
	 public function store(Request $request)
    {
		   $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'catimg' =>'mimes:jpg.png,jpeg|max:2048',
            'status' => 'required',
        ]);
		
		$file = $request->file('catimg');
		if($file){
		$fileName = time().'.'.$file->getClientOriginalExtension();
		
		$destinationPaththumb = 'uploads/categories/thumbnail';
		$img = Image::make($file->getRealPath());
        $img->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPaththumb.'/'.$fileName);
        
		$destinationPathfull = 'uploads/categories/full';
		$file->move($destinationPathfull,$fileName);
		}else{
			$fileName ="n/a";
		}

		$Category = new Category;
        $Category->name = $request->post('name');       
        $Category->catimg = $fileName;
        $Category->description =$request->post('description');
		$Category->status =$request->post('status');        
        
	    $Category->save();
	    $request->session()->flash('success', 'Category Menu added successfully');
		
        return view('pages.admin.category.create');
    }
}