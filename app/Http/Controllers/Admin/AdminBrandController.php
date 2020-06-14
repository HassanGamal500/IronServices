<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBrandController extends Controller
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
        $brands = DB::table('brands')
            ->join('brand_description', 'brand_description.brand_id', '=', 'brands.brand_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->select('brands.brand_id as id', 'brand_name as name')
            ->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function storeBrand(Request $request){
        $validator = validator()->make($request->all(), [
            'brand_name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $type_id = auth()->guard('admin')->user()->id;

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->brand_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->brand_name[2])) {
            $brand = DB::table('brands')
                ->insertGetId(['admin_id' => $type_id]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('brand_description')
                    ->insert([
                        'brand_name' => $request->brand_name[$i],
                        'language_id' => $i,
                        'brand_id' => $brand
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->brand_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $brands = DB::table('brands')
            ->join('brand_description', 'brand_description.brand_id', '=', 'brands.brand_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->select('brands.brand_id as id', 'brand_name as name')
            ->get();
        $arr=array('status'=>'1','data'=>$brands);
        return response()->json($arr);
    }

    public function editBrand(Request $request) {
        $brands = DB::table('brands')
            ->join('brand_description', 'brand_description.brand_id', '=', 'brands.brand_id')
            ->where('brands.brand_id', '=', $request->id)
            ->select('brands.brand_id as id', 'brand_name as name')
            ->get();
        return response()->json($brands);
    }

    public function updateBrand(Request $request) {
        $validator = validator()->make($request->all(), [
            'brand_name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->brand_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->brand_name[2])) {
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('brand_description')
                    ->where('brand_id', '=', $request->id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'brand_name' => $request->brand_name[$i],
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->brand_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

            
        $type_id = auth()->guard('admin')->user()->id;
        $brands = DB::table('brands')
            ->join('brand_description', 'brand_description.brand_id', '=', 'brands.brand_id')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->select('brands.brand_id as id', 'brand_name as name')
            ->get();
        $arr=array('status'=>'1','data'=>$brands);
        return response()->json($arr);
    }

    public function destroyBrand(Request $request, $id){
        $service = DB::table('brands')
            ->where('brand_id', '=', $id)
            ->delete();
    }
}
