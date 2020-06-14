<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    protected $user;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type == 1){
                return redirect('/permission');
            }
            return $next($request);
        });
    }
    
    public function index(){
        $type = auth()->guard('admin')->user()->id;
        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type)
            ->select('categories.category_id as id', 'category_name as name', 'category_image as image', 'category_color as color')
            ->orderBy('categories.category_id', 'desc')
            ->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request){
        $validator = validator()->make($request->all(), [
            'category_name' => 'required',
            'category_color' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if ($request->hasFile('image')) {
            $imageName = Storage::disk('edit_path')->putFile('images/category', $request->file('image'));
        } else {
            $imageName = 'images/category/category_avatar.png';
        }

        $type = auth()->guard('admin')->user()->id;

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->category_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->category_name[2])) {
            $category = DB::table('categories')
                ->insertGetId([
                    'category_image' => $imageName,
                    'category_color' => $request->category_color,
                    'admin_id' => $type
                ]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('category_description')
                    ->insert([
                        'category_name' => $request->category_name[$i],
                        'language_id' => $i,
                        'category_id' => $category
                    ]);
            }

        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->category_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type)
            ->select('categories.category_id as id', 'category_name as name', 'category_image as image', 'category_color as color')
            ->orderBy('categories.category_id', 'desc')
            ->get();
        $arr=array('status'=>'1','data'=>$categories);
        return response()->json($arr);
    }

    public function editCategory(Request $request) {
        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('categories.category_id', '=', $request->id)
            ->select('categories.category_id as id', 'category_name as name', 'category_image as image', 'category_color as color')
            ->get();
        return response()->json($categories);
    }

    public function updateCategory(Request $request) {
        $validator = validator()->make($request->all(), [
            'category_name' => 'required',
            'category_color' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if ($request->hasFile('image')) {
            $imageName = Storage::disk('edit_path')->putFile('images/category', $request->file('image'));
        } else {
            $imageName = $request->old_image;
        }

        $type = auth()->guard('admin')->user()->id;

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->category_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->category_name[2])) {
            $category = DB::table('categories')
                ->where('category_id', '=', $request->id)
                ->update([
                    'category_image' => $imageName,
                    'category_color' => $request->category_color,
                    'admin_id' => $type
                ]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('category_description')
                    ->where('category_id', '=', $request->id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'category_name' => $request->category_name[$i],
                        'language_id' => $i,
                    ]);
            }

        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->category_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type)
            ->select('categories.category_id as id', 'category_name as name', 'category_image as image', 'category_color as color')
            ->orderBy('categories.category_id', 'desc')
            ->get();
        $arr=array('status'=>'1','data'=>$categories);
        return response()->json($arr);
    }

    public function destroyCategory(Request $request, $id){
        $getCategory = DB::table('categories')->select('category_image')->where('category_id', '=', $id)->first();
        if($getCategory->category_image != 'images/admin/category_avatar.png'){
            $myFile = base_path($getCategory->category_image);
            File::delete($myFile);
        }
        $service = DB::table('categories')
            ->where('category_id', '=', $id)
            ->delete();
    }
}
