<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
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
        $type_id = auth()->guard('admin')->user()->id;
        $products = DB::table('products')
            ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->select('products.product_id', 'product_image', 'price', 'discount', 'product_name')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->orderBy('products.product_id', 'desc')
            ->get();
        return view('admin.products.index', compact('products'));
    }

    public function addProduct(){
        $type_id = auth()->guard('admin')->user()->id;
        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->select('categories.category_id as id', 'category_name as name')
            ->get();
        $brands = DB::table('brands')
            ->join('brand_description', 'brand_description.brand_id', '=', 'brands.brand_id')
            ->where('admin_id', '=', $type_id)
            ->where('language_id', '=', language())
            ->select('brands.brand_id as id', 'brand_name as name')
            ->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function storeProduct(Request $request) {
        $validator = validator()->make($request->all(), [
            'product_name' => 'required|max:70',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'discount' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if (preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->product_name[1])
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->product_name[2])
        && preg_match("/^[0-9.]+$/i", convert($request->discount))
        && preg_match("/^[0-9.]+$/i", convert($request->price))) {
            if ($request->hasFile('product_image')) {
                $imageName = Storage::disk('edit_path')->putFile('images/product', $request->file('product_image'));
            } else {
                $imageName = 'images/product/avatar_product.png';
            }

            $products = DB::table('products')
                ->insertGetId([
                    'product_image' => $imageName,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id
                ]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('product_description')
                    ->insert([
                        'product_name' => $request->product_name[$i],
                        'language_id' => $i,
                        'product_id' => $products
                    ]);
            }
        } else {
            if(!preg_match("/^[0-9.]+$/i", convert($request->discount)) && !preg_match("/^[0-9.]+$/i", convert($request->price))) {
                $error = trans('admin.latitude and longitude must contain only number and dot');
            } elseif(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->product_name[1])) {
                $error = trans('admin.this name must be contain only english characters');
            } elseif(!preg_match("/^[\p{Arabic}\s\p{N}]+$/u", $request->product_name[2])) {
                $error = trans('admin.this name must be contain only arabic characters');
            } else {
                $error = trans('admin.this name must contain only characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function editProduct($id){
        $type_id = auth()->guard('admin')->user()->id;
        $products = DB::table('products')
            ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
            ->where('products.product_id', '=', $id)
            ->orderBy('products.product_id', 'desc')
            ->get();

        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->select('categories.category_id as id', 'category_name as name')
            ->get();
        $brands = DB::table('brands')
            ->join('brand_description', 'brand_description.brand_id', '=', 'brands.brand_id')
            ->where('admin_id', '=', $type_id)
            ->where('language_id', '=', language())
            ->select('brands.brand_id as id', 'brand_name as name')
            ->get();

        return view('admin.products.edit', compact('products', 'categories', 'brands'));
    }

    public function updateProduct(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'product_name' => 'required|max:70',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'discount' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        if (preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->product_name[1])
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->product_name[2])
        && preg_match("/^[0-9.]+$/i", convert($request->discount))
        && preg_match("/^[0-9.]+$/i", convert($request->price))) {
            $products = DB::table('products')
                ->where('product_id', '=', $id)
                ->update([
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id
                ]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('product_description')
                    ->where('product_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'product_name' => $request->product_name[$i],
                    ]);
            }

            $getImage = DB::table('products')->where('product_id', '=', $id)->select('product_image')->first();

            if ($request->hasFile('product_image')) {
                if($getImage->image != 'images/product/avatar_product.png'){
                    $myFile = base_path($getImage->product_image);
                    File::delete($myFile);
                }
                $imageName = Storage::disk('edit_path')->putFile('images/product', $request->file('product_image'));
                $user = DB::table('products')->where('product_id', '=', $id)->update(['product_image' => $imageName]);
            } else {
                $imageName = $request->old_image;
                $user = DB::table('products')->where('product_id', '=', $id)->update(['product_image' => $imageName]);
            }
        } else {
            if(!preg_match("/^[0-9.]+$/i", convert($request->discount)) && !preg_match("/^[0-9.]+$/i", convert($request->price))) {
                $error = trans('admin.latitude and longitude must contain only number and dot');
            } elseif(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->product_name[1])) {
                $error = trans('admin.this name must be contain only english characters');
            } elseif(!preg_match("/^[\p{Arabic}\s\p{N}]+$/u", $request->product_name[2])) {
                $error = trans('admin.this name must be contain only arabic characters');
            } else {
                $error = trans('admin.this name must contain only characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroyProduct(Request $request, $id){
        $getImage = DB::table('products')->where('product_id', '=', $id)->select('product_image')->first();
        if($getImage->product_image != 'images/product/avatar_product.png'){
            $myFile = base_path($getImage->product_image);
            File::delete($myFile);
        }
        $service = DB::table('products')
            ->where('product_id', '=', $id)
            ->delete();
    }
}
