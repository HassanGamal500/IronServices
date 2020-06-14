<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function histories(Request $request) {
//        $array= array();
        $validator = validator()->make($request->all(), [
            'user_id' => 'required',
            'service_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $orders = DB::table('orders')
            ->where('user_id', '=', $request->user_id)
            ->where('admin_id','=', $request->service_id)
            ->select('order_id', 'order_detail', 'status_id', 'orders.created_at')
            ->orderBy('orders.created_at', 'desc')
            ->get();


        foreach ($orders as $order){
            $rate = DB::table('rates')
                ->where('admin_id', '=', $request->service_id)
                ->where('user_id', '=', $request->user_id)
                ->where('order_id', '=', $order->order_id)
                ->count();
            if ($rate > 0){
                $order->isRate = 1;
            } else {
                $order->isRate = 0;
            }
//            $array[strtotime($order->created_at)] = $order;
//            $array[] = $order;
        }
//        krsort($array);
//        foreach($array as $value){
//            $allData[]=$value;
//        }

//         dd($orders);
        if ($orders){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $orders
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function notifications(Request $request){
        $validator = validator()->make($request->all(), [
            'user_id' => 'required',
            'service_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $array = array();
        $notifications = DB::table('notifications')
            ->join('notification_description', 'notification_description.notification_id', '=', 'notifications.notification_id')
            ->where('user_id', '=', $request->user_id)
            // ->orwhere('user_id', '=', 0)
            ->where('type_id', '=', $request->service_id)
            ->where('language_id', '=', $request->language_id)
            ->select('notification_name','notification_content', 'notification_image', 'notifications.created_at')
            ->orderBy('notifications.notification_id', 'desc')
            ->get();

        if (!empty($notifications)){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $notifications
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
        }

        return response()->json($response);

    }

    public function rates(Request $request) {
        $validator = validator()->make($request->all(), [
            'star' => 'required',
            'comment' => 'required',
            'user_id' => 'required',
            'service_id' => 'required',
            'order_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $rate = DB::table('rates')
            ->insert([
                'rate_star' => $request->star,
                'rate_content' => $request->comment,
                'user_id' => $request->user_id,
                'admin_id' => $request->service_id,
                'order_id' => $request->order_id
            ]);

        if($rate) {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $rate
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function allRates(Request $request) {
        $validator = validator()->make($request->all(), [
            'service_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $rates = DB::table('rates')
            ->join('users', 'users.id', '=', 'rates.user_id')
            ->where('admin_id', '=', $request->service_id)
            ->select('rate_star', 'rate_content', 'name', 'image')
            ->get();

        if($rates) {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $rates
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function orderDetail(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'service_id' => 'required',
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $orders = DB::table('orders')
            ->join('status_description', 'status_description.status_id', '=', 'orders.status_id')
            ->select('orders.order_id', 'orders.status_id', 'order_detail', 'user_id', 'address_id', 'price')
            ->where('orders.order_id', '=', $request->order_id)
            ->where('admin_id', '=', $request->service_id)
            ->where('language_id', '=', $request->language_id)
            ->get();

        foreach ($orders as $order){
            $comment = DB::table('history_status')
                ->where('order_id', '=', $order->order_id)
                ->select('history_status_id', 'comment', 'created_at')
                ->get();
            $order->comments = $comment;
            $images = DB::table('order_image')->where('order_id', '=', $order->order_id)->get();
            $order->images = $images;
            $address = DB::table('user_address')
                ->where('user_address_id', '=', $order->address_id)
                ->select('user_address_id', 'city_id as city', 'area_id as area', 'address_building', 'floor_name', 'street_number', 'landmark')
                ->first();
            $city = DB::table('city_description')
                ->where('city_id', '=', $address->city)
                ->where('language_id', '=', $request->language_id)
                ->select('city_id', 'city_name')
                ->first();
            $address->city = $city;
            $area = DB::table('area_description')
                ->where('area_id', '=', $address->area)
                ->where('language_id', '=', $request->language_id)
                ->select('area_id', 'area_name')
                ->first();
            $address->area = $area;
            $order->address = $address;
            $rate = DB::table('rates')
                ->where('admin_id', '=', $request->service_id)
                ->where('order_id', '=', $order->order_id)
                ->count();
            if ($rate > 0){
                $order->isRate = 1;
            } else {
                $order->isRate = 0;
            }
        }

        if($orders) {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $orders
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
        }

        return response()->json($response);
    }
}
