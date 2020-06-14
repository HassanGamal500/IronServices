<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminCityController extends Controller
{
    protected $user;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type != 1){
                return redirect('/permission');
            }
            return $next($request);
        });
    }
    
    public function index(){
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('language_id', '=', language())
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function storeCity(Request $request){
        $validator = validator()->make($request->all(), [
            'city_name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->city_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->city_name[2])) {
            $city = DB::table('cities')
                ->insertGetId(['country_id' => 1]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('city_description')
                    ->insert([
                        'city_name' => $request->city_name[$i],
                        'language_id' => $i,
                        'city_id' => $city
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->city_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('language_id', '=', language())
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        $arr=array('status'=>'1','data'=>$cities);
        return response()->json($arr);
    }

    public function editCity(Request $request) {
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('cities.city_id', '=', $request->id)
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        return response()->json($cities);
    }

    public function updateCity(Request $request) {
        $validator = validator()->make($request->all(), [
            'city_name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->city_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->city_name[2])) {
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('city_description')
                    ->where('city_id', '=', $request->id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'city_name' => $request->city_name[$i],
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->city_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }
        
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('language_id', '=', language())
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        $arr=array('status'=>'1','data'=>$cities);
        return response()->json($arr);
    }

    public function destroyCity(Request $request, $id){
        $service = DB::table('cities')
            ->where('city_id', '=', $id)
            ->delete();
    }
}
