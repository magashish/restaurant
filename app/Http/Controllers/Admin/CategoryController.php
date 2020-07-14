<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Validator;
use Session;
use DataTables;
use Image;
use DB;

class CategoryController extends Controller
{
	public function index(Request $request)
    {
        $categories = Category::orderBy('created_at','desc')->paginate(10);
        // dd($categories);
        return view('pages.admin.category.index',compact('categories'));
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

    public function editCategory(Request $request,$id)
    {
        $category_detail = Category::where('id',$id)->first();
        if($request->isMethod('post'))
        {
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
        
            $data = $request->all();
            DB::table('categories')->where('id',$id)->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'catimg' => $fileName,
                'status' => $data['status']
            ]);
            return redirect()->back()->with('success','Category Updated Successfully');
        }
        return view('pages.admin.category.edit',compact('category_detail'));
    }

    public function deleteCategory($id)
    {
        DB::table('categories')->where('id',$id)->delete();
        return redirect()->back()->with('success','Category Deleted Succesfully');
    }
}