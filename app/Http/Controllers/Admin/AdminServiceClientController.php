<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminServiceClientController extends Controller
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
    
    public function index($id){
        $serviceClient = DB::table('administration')
            ->where('type', '!=', 1)
            ->where('service_id', '=', $id)
            ->select('id', 'name', 'phone', 'email', 'image')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($serviceClient as $client) {
            $users = DB::table('users')->where('service_id', '=', $client->id)->count();
            $client->users = $users;
            $orders = DB::table('orders')->where('admin_id', '=', $client->id)->count();
            $client->orders = $orders;
            $reminders = DB::table('reminders')->where('admin_id', '=', $client->id)->count();
            $client->reminders = $reminders;
            $products = DB::table('products')->join('categories', 'categories.category_id', '=', 'products.category_id')->where('admin_id', '=', $client->id)->count();
            $client->products = $products;
        }
        
        return view('admin.service_client.index', compact('serviceClient', 'id'));
    }

    public function addServiceClient($id){
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('country_id', '=', 1)
            ->where('language_id', '=', language())
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        return view('admin.service_client.create', compact('cities', 'id'));
    }

    public function storeServiceClient(Request $request) {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:administration|max:13',
            'email' => 'required|unique:administration|email',
            'password' => 'required|min:8|regex:/^(?=.*?[a-z])(?=.*?[0-9])/',
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'city_id' => 'required',
            'percentage' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'color' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
            if ($request->hasFile('image')) {
                $imageName = Storage::disk('edit_path')->putFile('images/admin', $request->file('image'));
            } else {
                $imageName = 'images/user/admin_avatar.png';
            }

            if ($request->hasFile('logo')) {
                $logoName = Storage::disk('edit_path')->putFile('images/logo', $request->file('logo'));
            } else {
                $logoName = 'images/user/logo_avatar.png';
            }

            $admin = DB::table('administration')
                ->insertGetId([
                    'name' => $request->name,
                    'phone' => convert($request->phone),
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'image' => $imageName,
                    'type' => 2,
                    'country_id' => 1,
                    'city_id' => $request->city_id,
                    'percentage' => $request->percentage,
                    'logo' => $logoName,
                    'color' => $request->color,
                    'service_id' => $request->service_id
                ]);
            $page = DB::table('pages')->insertGetId(['admin_id' => $admin]);
            for ($i=1; $i <= 2; $i++) { 
                $description = DB::table('page_description')->insert([
                    'page_description_name' => 'test',
                    'page_description_content' => 'test',
                    'page_id' => $page,
                    'language_id' => $i
                ]);
            }
        } else {
            if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || preg_match("/[0-9]/u", $request->name)) {
                $error = trans('admin.this name must contain only characters');
                return Redirect::back()->withInput($request->all())->with('error', $error);
            } else {
                $error = trans('admin.your email is not correct');
                return Redirect::back()->withInput($request->all())->with('error', $error);
            }
        }

        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function editServiceClient($id){
        $services = DB::table('administration')
            ->where('id', '=', $id)
            ->get();
        $service_id = DB::table('service_description')
            ->where('language_id', '=', language())
            ->select('service_id as id', 'service_name as name')
            ->get();
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('country_id', '=', 1)
            ->where('language_id', '=', language())
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        return view('admin.service_client.edit', compact('services', 'service_id', 'cities'));
    }

    public function updateServiceClient(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required|max:13',
            'email' => 'required|email',
            'password' => 'nullable|min:8|regex:/^(?=.*?[a-z])(?=.*?[0-9])/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'city_id' => 'required',
            'percentage' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'color' => 'required',
            'active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
            $getUser = Admin::find($id);
            $allPhone = Admin::where('phone', convert($request->phone))->where('id', '!=', $id)->first();
            $allEmail = Admin::where('email', $request->email)->where('id', '!=', $id)->first();

            if($request->name){
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['name' => $request->name]);
            }

            if ($allPhone) {
                $error = trans('admin.This phone has been taken before');
                return Redirect::back()->with('error', $error);
            } else {
                $getUser->phone = convert($request->phone);
                $getUser->save();
            }

            if ($allEmail) {
                $error = trans('admin.This Email has been taken before');
                return Redirect::back()->with('error', $error);
            } else {
                $getUser->email = $request->email;
                $getUser->save();
            }

            if ($request->password) {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['password' => bcrypt($request->password),]);
            }

            if ($request->hasFile('image')) {
                if($getUser->image != 'images/admin/admin_avatar.png'){
                    $myFile = base_path($getUser->image);
                    File::delete($myFile);
                }

                $imageName = Storage::disk('edit_path')->putFile('images/admin', $request->file('image'));

                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['image' => $imageName]);
            } else {
                $imageName = $request->old_image;
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['image' => $imageName]);
            }

            if ($request->city_id) {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['city_id' => $request->city_id]);
            }

            if ($request->percentage) {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['percentage' => $request->percentage]);
            }

            if ($request->hasFile('logo')) {
                if($getUser->image != 'images/logo/logo_avatar.png'){
                    $myFile = base_path($getUser->image);
                    File::delete($myFile);
                }

                $imageName = Storage::disk('edit_path')->putFile('images/logo', $request->file('logo'));

                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['logo' => $imageName]);
            } else {
                $imageName = $request->old_logo;
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['logo' => $imageName]);
            }

            if($request->color) {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['color' => $request->color]);
            }

            if ($request->active == 1) {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['active' => $request->active]);
            } else {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['active' => $request->active]);
            }

            if ($request->service_id) {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['service_id' => $request->service_id]);
            } else {
                $admin = DB::table('administration')
                    ->where('id', '=', $id)
                    ->update(['service_id' => $request->service_id]);
            }
        } else {
            if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || preg_match("/[0-9]/u", $request->name)) {
                $error = trans('admin.this name must contain only characters');
                return Redirect::back()->withInput($request->all())->with('error', $error);
            } else {
                $error = trans('admin.your email is not correct');
                return Redirect::back()->withInput($request->all())->with('error', $error);
            }
        }

        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroyServiceClient(Request $request, $id){
        $getUser = Admin::find($id);
        if($getUser->logo != 'images/admin/logo_avatar.png' && $getUser->image != 'images/admin/admin_avatar.png'){
            $myLogo = base_path($getUser->logo);
            File::delete($myLogo);

            $myImage = base_path($getUser->image);
            File::delete($myImage);
        }
        $admin = DB::table('administration')
            ->where('id', '=', $id)
            ->delete();
    }
}
