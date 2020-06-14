<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminOrderController extends Controller
{
    protected $user;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type == 1){
                return redirect('/permission');
            }
            return $next($request);
        })->except('indexAdmin', 'showOrder');
    }

    public function index(){
        $type = auth()->guard('admin')->user()->id;
        $orders = DB::table('orders')
            ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
            ->select('order_id as id', 'status_name', 'user_name as name')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $type)
            ->orderBy('order_id', 'desc')
            ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function indexAdmin($id){
        $orders = DB::table('orders')
            ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
            ->select('order_id as id', 'status_name', 'user_name as name')
            ->where('language_id', '=', language())
            ->where('admin_id', '=', $id)
            ->orderBy('order_id', 'desc')
            ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id){
        $checkFromOrder = DB::table('orders')->where('order_id', '=', $id)->select('user_id', 'admin_id', 'address_id')->first();
        $checkAddress = DB::table('user_address')->where('user_address_id', '=', $checkFromOrder->address_id)->select('city_id', 'area_id')->first();
        if ($checkAddress == null) {
            $checkAddress = 0;
            $checkCity = 0;
            $checkArea = 0;
        } else {
            $checkCity = DB::table('cities')->where('city_id', '=', $checkAddress->city_id)->count();
            $checkArea = DB::table('areas')->where('area_id', '=', $checkAddress->area_id)->count();
        }
        $checkUserFromUsers = DB::table('users')->where('id', '=', $checkFromOrder->user_id)->count();
        $checkAdminFromAdministrations = DB::table('administration')->where('id', '=', $checkFromOrder->admin_id)->count();
        

        if ($checkUserFromUsers > 0 && $checkCity > 0 && $checkArea > 0) {
            $orders = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('user_address', 'user_address.user_id', '=', 'orders.user_id')
                ->join('city_description', 'city_description.city_id', '=', 'user_address.city_id')
                ->join('area_description', 'area_description.area_id', '=', 'user_address.area_id')
                ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
                ->select('order_id as id', 'status_name', 'name', 'user_address.address_building', 'user_address.street_number', 'user_address.floor_name', 'user_address.landmark',
                    'phone', 'area_description.area_name', 'city_description.city_name', 'price', 'order_detail', 'orders.status_id', 'admin_id')
                ->where('city_description.language_id', '=', language())
                ->where('area_description.language_id', '=', language())
                ->where('status_description.language_id', '=', language())
                ->where('orders.order_id', '=', $id)
                ->orderBy('order_id', 'desc')
                ->get();

            foreach ($orders as $order){
                $images = DB::table('order_image')
                    ->where('order_id', '=', $order->id)
                    ->select('order_image as image')
                    ->get();
                $order->images = $images;
                $administration = DB::table('administration')->where('id', '=', $order->admin_id)->first();
                $order->administration = $administration;
            }
        } elseif ($checkUserFromUsers > 0 && $checkCity > 0 && $checkArea == 0) {
            $orders = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('user_address', 'user_address.user_id', '=', 'orders.user_id')
                ->join('city_description', 'city_description.city_id', '=', 'user_address.city_id')
                ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
                ->select('order_id as id', 'status_name', 'name', 'user_address.address_building', 'user_address.street_number', 'user_address.floor_name', 'user_address.landmark',
                    'phone', 'area_name', 'city_description.city_name', 'price', 'order_detail', 'orders.status_id', 'admin_id')
                ->where('city_description.language_id', '=', language())
                ->where('status_description.language_id', '=', language())
                ->where('orders.order_id', '=', $id)
                ->orderBy('order_id', 'desc')
                ->get();

            foreach ($orders as $order){
                $images = DB::table('order_image')
                    ->where('order_id', '=', $order->id)
                    ->select('order_image as image')
                    ->get();
                $order->images = $images;
                $administration = DB::table('administration')->where('id', '=', $order->admin_id)->first();
                $order->administration = $administration;
            }
        } elseif ($checkUserFromUsers > 0 && $checkCity == 0 && $checkArea == 0) {
            $orders = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
                ->select('order_id as id', 'status_name', 'name', 'user_address.address_building', 'user_address.street_number', 'user_address.floor_name', 'user_address.landmark',
                    'phone', 'area_name', 'city_name', 'price', 'order_detail', 'orders.status_id', 'admin_id')
                ->where('status_description.language_id', '=', language())
                ->where('orders.order_id', '=', $id)
                ->orderBy('order_id', 'desc')
                ->get();

            foreach ($orders as $order){
                $images = DB::table('order_image')
                    ->where('order_id', '=', $order->id)
                    ->select('order_image as image')
                    ->get();
                $order->images = $images;
                $administration = DB::table('administration')->where('id', '=', $order->admin_id)->first();
                $order->administration = $administration;
            }
        } else {
            $orders = DB::table('orders')
                ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
                ->select('order_id as id', 'status_name', 'user_name as name', 'address_building', 'street_number', 'floor_name', 'landmark',
                    'user_phone as phone', 'area_name', 'city_name', 'price', 'order_detail', 'orders.status_id', 'admin_id')
                ->where('status_description.language_id', '=', language())
                ->where('orders.order_id', '=', $id)
                ->orderBy('order_id', 'desc')
                ->get();

            foreach ($orders as $order){
                $images = DB::table('order_image')
                    ->where('order_id', '=', $order->id)
                    ->select('order_image as image')
                    ->get();
                $order->images = $images;
                $administration = DB::table('administration')->where('id', '=', $order->admin_id)->first();
                $order->administration = $administration;
            }
        }
            

        $histories = DB::table('history_status')
            ->join('status_description', 'status_description.status_id', '=', 'history_status.status_id')
            ->where('order_id', '=', $id)
            ->where('language_id', '=', language())
            ->select('history_status.created_at', 'status_name', 'comment')
            ->orderBy('history_status_id', 'desc')
            ->get();

        if ($orders[0]->status_id == 1){
            $status = DB::table('status')
                ->join('status_description', 'status_description.status_id', '=', 'status.status_id')
                ->select('status.status_id as id', 'status_name as name')
                ->where('language_id', '=', language())
                ->whereIn('status.status_id', [2, 5])
                ->get();
        } else {
            $status = DB::table('status')
                ->join('status_description', 'status_description.status_id', '=', 'status.status_id')
                ->select('status.status_id as id', 'status_name as name')
                ->where('language_id', '=', language())
                ->whereIn('status.status_id', [4, 6])
                ->get();
        }

//        $status = DB::table('status')
//            ->join('status_description', 'status_description.status_id', '=', 'status.status_id')
//            ->select('status.status_id as id', 'status_name as name')
//            ->where('language_id', '=', language())
//            ->whereIn('status.status_id', [2, 4, 5])
//            ->get();

        return view('admin.orders.show', compact('orders', 'histories', 'status'));
    }

    public function status(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'status_id' => 'required',
            'comment' => 'nullable',
            'price' => 'nullable'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        $CustomersPush = new CustomersPush();
        
        if(auth()->guard('admin')->user()->type == 2) {
            $checkStatusOrder = DB::table('orders')->where('order_id', '=', $id)->select('status_id')->first();
            if (($request->status_id == $checkStatusOrder->status_id) == 2) {
                $error = trans('admin.the order was accepted before');
                return Redirect::back()->with('error', $error);
            } elseif (($request->status_id == $checkStatusOrder->status_id) == 3) {
                $error = trans('admin.the order was progressed before');
                return Redirect::back()->with('error', $error);
            } elseif (($request->status_id == $checkStatusOrder->status_id) == 4) {
                $error = trans('admin.the order was delivered before');
                return Redirect::back()->with('error', $error);
            } elseif (($request->status_id == $checkStatusOrder->status_id) == 5) {
                $error = trans('admin.the order was rejected before');
                return Redirect::back()->with('error', $error);
            } elseif (($request->status_id == $checkStatusOrder->status_id) == 6) {
                $error = trans('admin.the order was canceled before');
                return Redirect::back()->with('error', $error);
            }
            

            if($request->comment){
                $insert = DB::table('history_status')->insert([
                    'order_id' => $id,
                    'status_id' => $request->status_id,
                    'comment' => $request->comment,
                ]);
            } else {
                $insert = DB::table('history_status')->insert([
                    'order_id' => $id,
                    'status_id' => $request->status_id,
                ]);
            }

            if($request->price) {
                $update = DB::table('orders')
                    ->where('order_id', '=', $id)
                    ->update([
                        'status_id' => $request->status_id,
                        'price' => $request->price
                    ]);
            } else {
                $update = DB::table('orders')
                    ->where('order_id', '=', $id)
                    ->update([
                        'status_id' => $request->status_id,
                    ]);
            }

            $getId = DB::table('orders')->where('orders.order_id', '=', $id)
                // ->join('administration', 'administration.id', '=', 'orders.admin_id')
                // ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
                ->select('orders.order_id', 'user_id', 'admin_name', 'status_id', 'admin_id')
                // ->where('status_description.language_id', '=', language())
                ->get();
            foreach($getId as $status){
                $title = DB::table('status_description')->where('status_id', '=', $status->status_id)->get();
                $status->titles = $title;
            }

            $type_id = auth()->guard('admin')->user()->id;

            if($request->status_name == 3) {
                $notify = DB::table('notifications')->insertGetId([
                    'notification_image' => 'images/admin/admin_avatar.png',
                    'user_id' => $getId[0]->user_id,
                    'type' => 2,
                    'type_id' => $type_id,
                    'created_at' => get_local_time($request->getClientIp())
                ]);
                for ($i = 0; $i <= 1; $i++){
                    $description = DB::table('notification_description')
                        ->insert([
                            'notification_name' => $getId[0]->admin_name,
                            'notification_content' => $getId[0]->titles[$i]->status_title . ' , ' . $request->comment,
                            'language_id' => $i+1,
                            'notification_id' => $notify
                        ]);
                }
            }else{
                $notify = DB::table('notifications')->insertGetId([
                    'notification_image' => 'images/admin/admin_avatar.png',
                    'user_id' => $getId[0]->user_id,
                    'type' => 2,
                    'type_id' => $type_id,
                    'created_at' => get_local_time($request->getClientIp())
                ]);
                for ($i = 0; $i <= 1; $i++){
                    $description = DB::table('notification_description')
                        ->insert([
                            'notification_name' => $getId[0]->admin_name,
                            'notification_content' => $getId[0]->titles[$i]->status_title . ' , ' . $request->comment,
                            'language_id' => $i+1,
                            'notification_id' => $notify
                        ]);
                }
            }
            $customersToken = DB::table('users')->select('token')->where('active','1')->where('id',$getId[0]->user_id)->get();
            foreach($customersToken as $customer){
                $customersTokenArr[]=$customer->token;
            }
            $getUserLanguage = DB::table('users')->select('default_language')->where('id', '=', $getId[0]->user_id)->first();
            if ($getUserLanguage == null) {
                $not = DB::table('notification_description')
                    ->select('notification_name', 'notification_content')
                    ->where('language_id', '=', 2)
                    ->where('notification_id', '=', $notify)
                    ->first();
            } else {
                $not = DB::table('notification_description')
                    ->select('notification_name', 'notification_content')
                    ->where('language_id', '=', $getUserLanguage->default_language)
                    ->where('notification_id', '=', $notify)
                    ->first();
            }
                
            if($request->status_name == 3) {
                $CustomersPush->send($not->notification_name, $not->notification_content,$customersTokenArr,'','1', '', $id);
            } else {
                $CustomersPush->send($not->notification_name, $not->notification_content,$customersTokenArr,'','1', '', $id);
            }

            // $notify = DB::table('notifications')->insert([
            //     'notification_name' => $getId->name,
            //     'notification_content' => $getId->status_title.' , '.$request->comment,
            //     'notification_image' => 'images/admin/avatar_admin.png',
            //     'user_id' => $getId->user_id,
            //     'type' => 2,
            //     'type_id' => $getId->order_id
            // ]);
            // $customersToken = DB::table('users')->select('token')->where('active','1')->where('id',$getId->user_id)->get();
            // foreach($customersToken as $customer){
            //     $customersTokenArr[]=$customer->token;
            // }
            // $CustomersPush->send($getId->name,$getId->status_title.' , '.$request->comment,$customersTokenArr,'','1');
        }

        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);

    }

    public function order_count(){
        $type_id = auth()->guard('admin')->user()->id;
        if(auth()->guard('admin')->user()->type == 2) {
            $allOrders = DB::table('orders')
                ->where('admin_id', '=', $type_id)
                ->where('status_id', '=', 1)
                ->count();
            return response()->json($allOrders);
        }
    }

    public function order_notify(){
        $type_id = auth()->guard('admin')->user()->id;
        if(auth()->guard('admin')->user()->type == 2) {
            $allOrders = DB::table('orders')
                ->where('admin_id', '=', $type_id)
                ->where('notify_count', '=', 0)
                ->count();
            $update = DB::table('orders')
                ->where('admin_id', '=', $type_id)
                ->where('notify_count', '=', 0)
                ->update(['notify_count' => 1]);
            return response()->json($allOrders);
        }
    }

}
