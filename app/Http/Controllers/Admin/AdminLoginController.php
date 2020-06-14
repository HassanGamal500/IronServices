<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {

        if (Auth::guard('admin')->check()){
            return redirect()->route('dashboard');
        } else {
            return view('admin.login.login');
        }
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails())
        {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $admin = \App\Admin::where('email', $request->email)->first();

        $credentials = array('email' => $request->email, 'password' => $request->password);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::guard('admin')->attempt($credentials, $remember_me)) {
            return redirect()->intended('/');
        } else {
            $error = trans('admin.Your Email Or Password Is Not Correct');
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
    }

    public function logout(Request $request)
    {
        $removeToken = DB::table('administration')->where('id', '=', auth()->guard('admin')->user()->id)->update(['token' => '']);
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    public function editProfile($id){
        $users = DB::table('administration')
            ->select('id', 'name', 'phone', 'email', 'image')
            ->where('id', '=', $id)
            ->first();
        return view('admin.profile.edit', compact('users', 'id'));
    }

    public function updateProfile(Request $request, $id) {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        $getUser = \App\Admin::find($id);
        $allPhone = \App\Admin::where('phone', convert($request->phone))->where('id', '!=', $id)->first();
        $allEmail = \App\Admin::where('email', $request->email)->where('id', '!=', $id)->first();

        $users = DB::table('administration')
            ->where('id', '=', $id)
            ->update(['name' => $request->name]);

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
            $users = DB::table('administration')
                ->where('id', '=', $id)
                ->update(['password' => bcrypt($request->password),]);
        }

        if ($request->hasFile('image')) {
            $imageName = 'images/admin/'.time().'_'.rand().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(base_path('images/admin/'), $imageName);

            $users = DB::table('administration')
                ->where('id', '=', $id)
                ->update(['image' => $imageName]);
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }
}
