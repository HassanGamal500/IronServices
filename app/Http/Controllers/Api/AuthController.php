<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function register(Request $request) {
        $validator = validator()->make($request->all(), [
            'name' => 'required|max:30',
            'email' => 'required|email',
            'phone' => 'required|max:11',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
            'service_id' => 'required'
        ]);

        if ($validator->fails()) {

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $checkEmail = User::where('service_id', '=', $request->service_id)->where('email', '=', strtolower($request->email))->count();
        $checkPhone = User::where('service_id', '=', $request->service_id)->where('phone', '=', $request->phone)->count();

        if(filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)){
            if ($checkEmail == 0 && $checkPhone ==0) {
                $user = new User();

                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->email = strtolower($request->email);
                $user->image = '/images/user/avatar_user.png';
                $user->password = bcrypt($request->password);
                $user->token = $request->token;
                $user->service_id = $request->service_id;
                $user->default_language = $request->language_id;
                $user->save();
                $response = [
                    'status' => 1,
                    'message' => trans('admin.success'),
                    'data' => $user
                ];
            } elseif ($checkEmail) {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This Email has been taken before'),
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This phone has been taken before'),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            if($request->name) {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.this name must contain only characters'),
                    'data' => []
                ];
                return response()->json($response);
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.your email is not correct'),
                    'data' => []
                ];
                return response()->json($response);
            }
        }
    }

    public function loginWithSocial(Request $request) {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'required',
            'provider_id' => 'required',
            'provider_type' => 'required|in:facebook,google',
            'service_id' => 'required'
        ]);

        if ($validator->fails()) {

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        // $user_id = $request->provider_id;
        // $user_token = $request->provider_token;
        // $accessLink = 'https://graph.facebook.com/v5.0/'. $user_id .'?fields=id,name,email,birthday&access_token=' . $user_token;
        // $responsez = file_get_contents($accessLink);
        // $response  =  json_decode($responsez, true);
        
        // $imageProfile = "https://graph.facebook.com/v5.0/". $user_id ."/picture?width=99999&height=99999&redirect=false&access_token=" . $user_token;
        // $imageResponsez = file_get_contents($imageProfile);
        // $imageResponse  =  json_decode($imageResponsez, true);
        // // return $imageResponse['data']['url'];
        // $newData = file_get_contents($imageResponse['data']['url']);
        // $dir="images/user";
        // $uploadfile = $dir."/pic_".time().".jpg";
        // file_put_contents(base_path().'/'.$uploadfile, $newData);
        // $profile_photo=$uploadfile;
        
        $checkAccount = User::where('service_id', '=', $request->service_id)
                        ->where('provider_facebook_id', '=', $request->provider_id)
                        ->orWhere('provider_google_id', '=', $request->provider_id)
                        ->count();

        if ($checkAccount == 0) {

            $checkEmail = User::where('email', '=', $request->email)->where('service_id', '=', $request->service_id)->count();

            if($checkEmail == 0) {

                $newData = file_get_contents($request->image);
                $dir="images/user";
                $uploadfile = $dir."/pic_".time().".jpg";
                file_put_contents(base_path().'/'.$uploadfile, $newData);
                $profile_photo=$uploadfile;

                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->image = $profile_photo;
                $user->token = $request->token;
                $user->service_id = $request->service_id;
                $user->default_language = $request->language_id;
                if ($request->provider_type == 'facebook') {
                    $user->provider_facebook_id = $request->provider_id;
                } else {
                    $user->provider_google_id = $request->provider_id;
                }
                $user->save();
                $userId = DB::table('users')->where('email', '=', $request->email)->where('service_id', '=', $request->service_id)->first();
                $response = [
                    'status' => 1,
                    'message' => trans('admin.success'),
                    'data' => $userId
                ];
            } else {
                if ($request->provider_type == 'facebook') {
                    DB::table('users')->where('email', '=', $request->email)->where('service_id', '=', $request->service_id)
                        ->update([
                            'token' => $request->token,
                            'provider_facebook_id' => $request->provider_id,
                        ]);
                } else {
                    DB::table('users')->where('email', '=', $request->email)->where('service_id', '=', $request->service_id)
                        ->update([
                            'token' => $request->token,
                            'provider_google_id' => $request->provider_id,
                        ]);
                }
                
                $user = DB::table('users')->where('email', '=', $request->email)->where('service_id', '=', $request->service_id)->first();
                $response = [
                    'status' => 1,
                    'message' => trans('admin.success'),
                    'data' => $user
                ];
            }

        } else {
            if ($request->provider_type == 'facebook') {
                DB::table('users')->where('provider_facebook_id', '=', $request->provider_id)->where('service_id', '=', $request->service_id)
                    ->update(['token' => $request->token]);
            } else {
                DB::table('users')->where('provider_google_id', '=', $request->provider_id)->where('service_id', '=', $request->service_id)
                    ->update(['token' => $request->token]);
            }
            
            $user = DB::table('users')->where('email', '=', $request->email)->where('service_id', '=', $request->service_id)->first();
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $user
            ];
        }
        return response()->json($response);
    } 

    public function login(Request $request) {

        if (is_numeric($request->input)) {
            $validator = validator()->make($request->all(), [
                'input' => 'required|max:11',
                'password' => 'required|min:8',
                'service_id' => 'required'
            ]);

            if ($validator->fails()){
                $response = [
                    'status' => 0,
                    'message' => trans("admin.your phone or password is not correct"),
                    'data' => []
                ];
                return response()->json($response);
            }
            $user = User::where('phone', $request->input)->where('service_id', '=', $request->service_id)->first();
        }elseif (filter_var(filter_var(strtolower($request->input), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
            $validator = validator()->make($request->all(), [
                'input' => 'required|email',
                'password' => 'required',
                'service_id' => 'required'
            ]);

            if ($validator->fails()){
                $response = [
                    'status' => 0,
                    'message' => trans('admin.your email or password is not correct'),
                    'data' => []
                ];
                return response()->json($response);
            }
            $user = User::where('email', strtolower($request->input))->where('service_id', '=', $request->service_id)->first();
        }else{
            $user=false;
        }

        if ($user) {
            $numOrder = DB::table('orders')
                ->where('user_id', '=', $user->id)
                ->where('admin_id', '=', $request->service_id)
                ->count();
            $user->numOrder = $numOrder;
            $numReminder = DB::table('reminders')
                ->where('user_id', '=', $user->id)
                ->where('admin_id', '=', $request->service_id)
                ->count();
            $user->numReminder = $numReminder;
            $address = DB::table('user_address')
                ->select('user_address_id', 'city_id as city', 'area_id as area', 'address_building', 'floor_name', 'street_number', 'landmark')
                ->where('user_id', '=', $user->id)
                ->get();
            foreach ($address as $object) {
                $city = DB::table('city_description')
                    ->where('city_id', '=', $object->city)
                    ->where('language_id', '=', $request->language_id)
                    ->select('city_id', 'city_name')
                    ->first();
                $object->city = $city;
                $area = DB::table('area_description')
                    ->where('area_id', '=', $object->area)
                    ->where('language_id', '=', $request->language_id)
                    ->select('area_id', 'area_name')
                    ->first();
                $object->area = $area;
            }
            $user->address = $address;
            $notifications = DB::table('notifications')->where('user_id', '=', $user->id)->where('is_seen', '=', 0)->count();
            $user->countNotification = $notifications;
            if (Hash::check($request->password, $user->password)) {
                $response = [
                    'status' => 1,
                    'message' => 'your account is correct',
                    'data' => [
                        'User' => $user
                    ]
                ];
                $lang = DB::table('users')->where('id', '=', $user->id)->update(['default_language' => $request->language_id]);
                DB::table('users')->where('email', strtolower($request->input))->orwhere('phone', $request->input)->update([
                    'token'=>$request->token
                ]);
                return response()->json($response);
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.your password is not correct, Try Again'),
                    'data' => []
                ];
                return response()->json($response);
            }

        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.your account is not correct'),
                'data' => []
            ];
            return response()->json($response);
        }

    }

    public function resetPassword(Request $request) {
        $validator = validator()->make($request->all(),[
            'phone' => 'required',
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            $code = rand(1111, 9999);
            $update = $user->update(['pin_code' => $code,'is_used' => 0]);

            if ($update) {
//                $to_name = $user->name;
//                $to_email = $user->email;
//                $data = array('name'=> $user->name, "body" => "Your Reset Code Is :".$code);
//
//                Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
//                    $message->to($to_email, $to_name)
//                        ->subject('Reset Password');
//                    $message->from('info@services.com','Services');
//                });

                $response = [
                    'status' => 1,
                    'message' => trans('admin.check your message on your phone'),
                    'data' => $code
                ];
                return response()->json($response);

            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.Please Try Again'),
                    'data' => []
                ];
                return response()->json($response);
            }

        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.your account is not exist'),
                'data' => []
            ];
            return response()->json($response);
        }

    }

    public function pinCode(Request $request) {
        $validator = validator()->make($request->all(),[
            'phone' => 'required',
            'pin_code' => 'required'
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);

        }

        $user = User::where('pin_code', $request->pin_code)
            ->where('phone', $request->phone)
            ->first();

        if ($user){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $user
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.This code is invalid'),
                'data' => []
            ];
            return response()->json($response);
        }
    }

    public function newPassword(Request $request) {

        $validator = validator()->make($request->all(),[
            'phone' => 'required',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);

        }

        $user = User::where('phone', $request->phone)->first();

        if ($user) {

            $user->password = bcrypt($request->password);
            $user->is_used = 1;

            if ($user->save()) {

                $response = [
                    'status' => 1,
                    'message' => trans('admin.password changed successfully'),
                    'data' => $user
                ];
                return response()->json($response);

            } else {

                $response = [
                    'status' => 0,
                    'message' => trans('admin.something wrong, try again'),
                    'data' => []
                ];
                return response()->json($response);

            }

        } else {

            $response = [
                'status' => 0,
                'message' => trans('admin.This phone is invalid'),
                'data' => []
            ];
            return response()->json($response);

        }
    }

    public function getProfile(Request $request) {
        //Hefny
        $validator= validator()->make($request->all(),[
            'id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }
        $id = $request->id;
//        $user=User::find($id);
        $user = DB::table('users')
            ->where('id', '=', $id)
            ->where('service_id', '=', $request->service_id)
            ->get();
        foreach ($user as $num) {
            $numOrder = DB::table('orders')
                ->where('user_id', '=', $request->id)
                ->where('admin_id', '=', $request->service_id)
                ->count();
            $num->numOrder = $numOrder;
            $numReminder = DB::table('reminders')
                ->where('user_id', '=', $request->id)
                ->where('admin_id', '=', $request->service_id)
                ->count();
            $num->numReminder = $numReminder;
            $address = DB::table('user_address')
                ->select('user_address_id', 'city_id as city', 'area_id as area', 'address_building', 'floor_name', 'street_number', 'landmark')
                ->where('user_id', '=', $num->id)
                ->get();
            foreach ($address as $object) {
                $city = DB::table('city_description')
                    ->where('city_id', '=', $object->city)
                    ->where('language_id', '=', $request->language_id)
                    ->select('city_id', 'city_name')
                    ->first();
                $object->city = $city;
                $area = DB::table('area_description')
                    ->where('area_id', '=', $object->area)
                    ->where('language_id', '=', $request->language_id)
                    ->select('area_id', 'area_name')
                    ->first();
                $object->area = $area;
            }
            $num->address = $address;
        }

        $notifications = DB::table('notifications')
            ->where('user_id', '=', $id)
            ->where('is_seen', '=', 0)
            ->count();

        $user->countNotification = $notifications;

        if($user){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $user
            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'Failed',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function updateProfile(Request $request) {

        $id = $request->user_id;
        $validator= validator()->make($request->all(),[
            'user_id' => 'required',
            'service_id' => 'required',
            'name' => 'required|max:30',
            'phone' => 'required|max:11',
            'email' => 'required|email',
            'password' => 'nullable|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);

        }

        $user=User::find($id);
        $allPhone = User::where('phone', $request->phone)->where('id', '!=', $id)->where('service_id', '=', $request->service_id)->first();
        $allEmail = User::where('email', $request->email)->where('id', '!=', $id)->where('service_id', '=', $request->service_id)->first();

        if ($user){

            if(preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
                $user->name = $request->name;
                $user->save();
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.this name must contain only characters'),
                    'data' => []
                ];
                return response()->json($response);
            }

            if ($allPhone) {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This phone has been taken before'),
                    'data' => []
                ];
                return response()->json($response);
            } else {
                $user->phone = $request->phone;
                $user->save();
            }

            if(filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
                if ($allEmail) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.This Email has been taken before'),
                        'data' => []
                    ];
                    return response()->json($response);
                } else {
                    $user->email = strtolower($request->email);
                    $user->save();
                }
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.your email is not correct'),
                    'data' => []
                ];
                return response()->json($response);
            }

            if(!empty($request->image)){
                $image = substr($request->image, strpos($request->image, ",") + 1);
                $img = base64_decode($image);
                $dir="images/user";
                if (!file_exists($dir) and !is_dir($dir)) {
                    mkdir($dir);
                }
                $uploadfile = $dir."/pic_".time().".jpg";
                file_put_contents(base_path().'/'.$uploadfile, $img);
                $profile_photo=$uploadfile;
                $user->image = $profile_photo;
                $user->save();
            }

            if ($request->password) {
                $user->password = bcrypt($request->password);
                $user->save;
            }

            $user->save();

            $response = [
                'status' => 1,
                'message' => trans('admin.update successfully'),
                'data' => $user
            ];
            return response()->json($response);

        }else{

            $response = [
                'status' => 0,
                'message' => trans('admin.failed'),
                'data' => $user
            ];
            return response()->json($response);

        }

    }
}
