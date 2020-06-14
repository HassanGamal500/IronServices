<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminServiceController extends Controller
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
        $services = DB::table('service_description')
            ->select('service_id as id', 'service_name as name')
            ->where('language_id', '=', language())
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.services.index', compact('services'));
    }

    public function addService(){
        return view('admin.services.create');
    }

    public function storeService(Request $request) {
        $validator = validator()->make($request->all(), [
            'service_name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->service_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->service_name[2])) {
            $service = DB::table('services')
                ->insertGetId(['service_id' => null]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('service_description')
                    ->insert([
                        'service_name' => $request->service_name[$i],
                        'language_id' => $i,
                        'service_id' => $service
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->service_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function editService($id){
        $services = DB::table('services')
            ->join('service_description', 'service_description.service_id', '=', 'services.service_id')
            ->where('services.service_id', '=', $id)
            ->select('services.service_id as id', 'service_name as name', 'active')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.services.edit', compact('services'));
    }

    public function updateService(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'service_name' => 'required',
            'active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->service_name[1]) 
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->service_name[2])) {
            if ($request->active == 1) {
                $admin = DB::table('services')
                    ->where('service_id', '=', $id)
                    ->update(['active' => $request->active]);
            } else {
                $admin = DB::table('services')
                    ->where('service_id', '=', $id)
                    ->update(['active' => $request->active]);
            }

            for ($i = 1; $i <= 2; $i++) {
                $description = DB::table('service_description')
                    ->where('service_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'service_name' => $request->service_name[$i],
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->service_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroyService(Request $request, $id){
        $service = DB::table('services')
            ->where('service_id', '=', $id)
            ->delete();
    }

    public function getToken(Request $request){
        $auth = auth()->guard('admin')->user()->id;
        $insertToken = DB::table('administration')->where('id', '=', $auth)->update(['token' => $request->token]);
        return response()->json($insertToken);
    }
    
    public function type(Request $request){
        $auth = auth()->guard('admin')->user()->type;
        if($auth == 1) { $type = 1; } else { $type = 2; };
        return response()->json($type);
    }
}
