<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAreaController extends Controller
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
        $areas = DB::table('areas')
            ->join('area_description', 'area_description.area_id', '=', 'areas.area_id')
            ->join('city_description', 'city_description.city_id', '=', 'areas.city_id')
            ->where('area_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->select('areas.area_id as id', 'area_name as name', 'city_name')
            ->orderBy('areas.area_id', 'desc')
            ->get();
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('country_id', '=', 1)
            ->where('language_id', '=', language())
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        return view('admin.areas.index', compact('areas', 'cities'));
    }

    public function storeArea(Request $request){
        $validator = validator()->make($request->all(), [
            'area_name' => 'required',
            'city_id' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->area_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->area_name[2])) {
            $area = DB::table('areas')
                ->insertGetId(['city_id' => $request->city_id]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('area_description')
                    ->insert([
                        'area_name' => $request->area_name[$i],
                        'language_id' => $i,
                        'area_id' => $area
                    ]);
            }

        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->area_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $areas = DB::table('areas')
            ->join('area_description', 'area_description.area_id', '=', 'areas.area_id')
            ->join('city_description', 'city_description.city_id', '=', 'areas.city_id')
            ->where('area_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->select('areas.area_id as id', 'area_name as name', 'city_name')
            ->orderBy('areas.area_id', 'desc')
            ->get();
        $arr=array('status'=>'1','data'=>$areas);
        return response()->json($arr);
    }

    public function editArea(Request $request) {
        $areas = DB::table('areas')
            ->join('area_description', 'area_description.area_id', '=', 'areas.area_id')
            ->where('areas.area_id', '=', $request->id)
            ->select('areas.area_id as id', 'area_name as name')
            ->get();
        return response()->json($areas);
    }

    public function updateArea(Request $request) {
        $validator = validator()->make($request->all(), [
            'area_name' => 'required',
            'city_id' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->area_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->area_name[2])) {
            $area = DB::table('areas')
                ->where('area_id', '=', $request->id)
                ->update(['city_id' => $request->city_id]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('area_description')
                    ->where('area_id', '=', $request->id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'area_name' => $request->area_name[$i],
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->area_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

            

        $areas = DB::table('areas')
            ->join('area_description', 'area_description.area_id', '=', 'areas.area_id')
            ->join('city_description', 'city_description.city_id', '=', 'areas.city_id')
            ->where('area_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->select('areas.area_id as id', 'area_name as name', 'city_name')
            ->orderBy('areas.area_id', 'desc')
            ->get();
        $arr=array('status'=>'1','data'=>$areas);
        return response()->json($arr);
    }

    public function destroyArea(Request $request, $id){
        $service = DB::table('areas')
            ->where('area_id', '=', $id)
            ->delete();
    }
}
