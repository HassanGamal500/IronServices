<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminImageController extends Controller
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
    
    public function index($id){
        $type_id = auth()->guard('admin')->user()->id;
        $images = DB::table('product_image')
            ->join('products', 'products.product_id', '=', 'product_image.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->select('image_id as id', 'image')
            ->where('admin_id', '=', $type_id)
            ->where('product_image.product_id', '=', $id)
            ->get();
        return view('admin.images.index', compact('images','id'));
    }

    public function storeImage(Request $request){
        $validator = validator()->make($request->all(), [
            'image' => 'required|array',
            'image.*' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if ($request->hasFile('image')) {
            foreach($request->image as $image) {
                $imageName = Storage::disk('edit_path')->putFile('images/image_product', $image);
                $img = DB::table('product_image')->insert(['image' => $imageName, 'product_id' => $request->product_id]);
            }
        } else {
            foreach ($request->image as $image) {
                $imageName = 'images/image_product/avatar_image_product.png';
                $img = DB::table('product_image')->insert(['image' => $imageName, 'product_id' => $request->product_id]);
            }
        }

        $type_id = auth()->guard('admin')->user()->id;
        $images = DB::table('product_image')
            ->join('products', 'products.product_id', '=', 'product_image.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->select('image_id as id', 'image')
            ->where('admin_id', '=', $type_id)
            ->where('product_image.product_id', '=', $request->product_id)
            ->get();
        $arr=array('status'=>'1','data'=>$images);
        return response()->json($arr);
    }

    public function destroyImage(Request $request, $id){
        $getImage = DB::table('product_image')->select('image')->where('image_id', '=', $id)->first();
        if($getImage->image != 'images/admin/avatar_image_product.png'){
            $myFile = base_path($getImage->image);
            File::delete($myFile);
        }
        $service = DB::table('product_image')
            ->where('image_id', '=', $id)
            ->delete();
    }
}
