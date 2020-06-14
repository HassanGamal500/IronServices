<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    protected $user;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type == 1){
                return redirect('/permission');
            }
            return $next($request);
        })->except('indexAdmin');
    }

    public function index(){
        $service_id = auth()->guard('admin')->user()->id;
        $users = DB::table('users')
            ->select('id', 'name', 'phone', 'email', 'image', 'active')
            ->where('service_id', '=', $service_id)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.users.index', compact('users'));
    }

    public function indexAdmin($id){
        $users = DB::table('users')
            ->select('id', 'name', 'phone', 'email', 'image', 'active')
            ->where('service_id', '=', $id)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.users.index', compact('users'));
    }

    public function addUser(){
        return view('admin.users.create');
    }

    public function storeUser(Request $request) {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|regex:/^(?=.*?[a-z])(?=.*?[0-9])/',
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
            if ($request->hasFile('image')) {
                $imageName = Storage::disk('edit_path')->putFile('images/user', $request->file('image'));
            } else {
                $imageName = 'images/user/avatar_user.png';
            }

            $service_id = auth()->guard('admin')->user()->id;

            $users = DB::table('users')
                ->insert([
                    'name' => $request->name,
                    'phone' => convert($request->phone),
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'image' => $imageName,
                    'service_id' => $service_id
                ]);

            $allUsers = DB::table('users')->orderBy('id', 'desc')->get();
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

    public function editUser($id){
        $users = DB::table('users')
            ->select('id', 'name', 'phone', 'email', 'image', 'active')
            ->where('id', '=', $id)
            ->first();
        return view('admin.users.edit', compact('users'));
    }

    public function updateUser(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8|regex:/^(?=.*?[a-z])(?=.*?[0-9])/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'active' => 'nullable'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
            $getUser = User::find($id);
            $allPhone = User::where('phone', convert($request->phone))->where('id', '!=', $id)->first();
            $allEmail = User::where('email', $request->email)->where('id', '!=', $id)->first();

            $users = DB::table('users')
                ->where('id', '=', $id)
                ->update(['name' => $request->name]);
            
            if ($allPhone) {
                $error = trans('admin.This phone has been taken before');
                return Redirect::back()->with('error', $error);
                // dd($allPhone);
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
                $users = DB::table('users')
                    ->where('id', '=', $id)
                    ->update(['password' => bcrypt($request->password),]);
            }

            if ($request->hasFile('image')) {
                if($getUser->image != 'images/user/avatar_user.png'){
                    $myFile = base_path($getUser->image);
                    File::delete($myFile);
                }

                $imageName = Storage::disk('edit_path')->putFile('images/user', $request->file('image'));

                $users = DB::table('users')
                    ->where('id', '=', $id)
                    ->update(['image' => $imageName]);
            } else {
                $imageName = $request->old_image;
                $users = DB::table('users')
                    ->where('id', '=', $id)
                    ->update(['image' => $imageName]);
            }

            $CustomersPush = new CustomersPush();
	        if ($request->active == 1) {
	            $users = DB::table('users')
	                ->where('id', '=', $id)
	                ->update(['active' => $request->active]);
	            
	            $customersToken = DB::table('users')->select('token')->where('id', '=', $id)->get();
	            foreach($customersToken as $customer){
	                $customersTokenArr[]=$customer->token;
	            }
	            $CustomersPush->send('User Activate','This User Is Active',$customersTokenArr,'','1');
	        } else {
	            $users = DB::table('users')
	                ->where('id', '=', $id)
	                ->update(['active' => $request->active]);
	                
	            $customersToken = DB::table('users')->select('token')->where('id', '=', $id)->get();
	            foreach($customersToken as $customer){
	                $customersTokenArr[]=$customer->token;
	            }
	            $CustomersPush->send('User InActive','This User Is InActive',$customersTokenArr,'','1');
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

//        if ($request->gender) {
//            $users = DB::table('users')
//                ->where('id', '=', $id)
//                ->update(['gender' => $request->gender]);
//        }
//
//        if ($request->active == 1) {
//            $users = DB::table('users')
//                ->where('id', '=', $id)
//                ->update(['active' => $request->active]);
//        } else {
//            $users = DB::table('users')
//                ->where('id', '=', $id)
//                ->update(['active' => $request->active]);
//        }

        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroyUser(Request $request, $id){
    	$CustomersPush = new CustomersPush();
        $customersToken = DB::table('users')->select('token', 'default_language')->where('id', '=', $id)->get();
        foreach($customersToken as $customer){
            $customersTokenArr[]=$customer->token;
        }
        if($customersToken[0]->default_language == 1) {
            $CustomersPush->send('Services','The user has been deleted',$customersTokenArr,'','1', '2');
        } else {
            $CustomersPush->send('الخدمات','تم حذف المستخدم',$customersTokenArr,'','1', '2');
        }
        $getUser = User::find($id);
        if($getUser->image != 'images/user/avatar_user.png'){
            $myFile = base_path($getUser->image);
            File::delete($myFile);
        }
        $users = DB::table('users')
            ->where('id', '=', $id)
            ->delete();
//        $allUsers = DB::table('users')
//            ->select('id', 'name', 'phone','email', 'image', 'service_id')
//            ->orderBy('id', 'desc')
//            ->get();

//        $table = '';
//        $num = 1;
//        foreach ($allUsers as $allUser){
//            $table = '<tr>';
//            $table .= '<td>'.$num.'</td>';
//            $table .= '<td>'.$allUser->name.'</td>';
//            $table .= '<td>'.$allUser->email.'</td>';
//            $table .= '<td>'.$allUser->phone.'</td>';
//            $table .= '<td><img src="'.asset("$allUser->image").'"></td>';
//            $table .= '<td><a class="btn-floating waves-effect waves-light gradient-45deg-light-blue-cyan" href="'.url(route('edit_user', $allUser->id)).'"><i class="material-icons">mode_edit</i></a></td>';
//            $table .= '<td><a class="btn-floating waves-effect waves-light gradient-45deg-purple-deep-orange alerts" data-url="'.asset('delete_user').'/" data-id="'.$allUser->id.'"><i class="material-icons">clear</i></a></td>';
//            $table .= '</tr>';
//        }
//        return response()->json($table);
    }
}
