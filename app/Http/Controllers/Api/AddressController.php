<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function getCities(Request $request){
        $validator= validator()->make($request->all(),[
            'language_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $areas = DB::table('cities')
            ->join('city_description','city_description.city_id', '=', 'cities.city_id')
            ->where('language_id', '=', $request->language_id)
            ->where('country_id', '=', 1)
            ->select('cities.city_id', 'city_name')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => $areas
        ];

        return response()->json($response);
    }

    public function getAreas(Request $request){
        $validator= validator()->make($request->all(),[
            'city_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $areas = DB::table('areas')
            ->join('area_description','area_description.area_id', '=', 'areas.area_id')
            ->where('language_id', '=', $request->language_id)
            ->where('city_id', '=', $request->city_id)
            ->select('areas.area_id', 'area_name')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => $areas
        ];

        return response()->json($response);
    }

    public function address(Request $request) {
        $validator= validator()->make($request->all(),[
            'user_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'address_building' => 'required',
            'floor_name' => 'required',
            'street_number' => 'required',
            'landmark' => 'nullable'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $address = DB::table('user_address')
            ->insertGetId([
                'country_id' => 1,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
                'user_id' => $request->user_id,
                'address_building' => $request->address_building,
                'floor_name' => $request->floor_name,
                'street_number' => $request->street_number,
                'landmark' => $request->landmark
            ]);

        $getAddress = DB::table('user_address')
//            ->join('city_description', 'city_description.city_id', '=', 'user_address.city_id')
//            ->join('area_description', 'area_description.area_id', '=', 'user_address.area_id')
            ->where('user_id', '=', $request->user_id)
            ->where('user_address_id', '=', $address)
            ->select('user_address_id', 'city_id', 'area_id', 'address_building', 'floor_name', 'street_number', 'landmark')
//            ->where('city_description.language_id', '=', $request->language_id)
//            ->where('area_description.language_id', '=', $request->language_id)
            ->first();
        $city = DB::table('city_description')
            ->where('city_id', '=', $getAddress->city_id)
            ->where('language_id', '=', $request->language_id)
            ->select('city_id', 'city_name')
            ->first();
        $getAddress->city = $city;
        $area = DB::table('area_description')
            ->where('area_id', '=', $getAddress->area_id)
            ->where('language_id', '=', $request->language_id)
            ->select('area_id', 'area_name')
            ->first();
        $getAddress->area = $area;

        if ($address){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $getAddress
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

    public function allAddress(Request $request) {
        $validator= validator()->make($request->all(),[
            'user_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $address = DB::table('user_address')
            ->where('user_id', '=', $request->user_id)
            ->select('user_address_id', 'city_id as city', 'area_id as area', 'address_building', 'floor_name', 'street_number', 'landmark')
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

        if ($address){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $address
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

    public function getAddress(Request $request) {
        $validator= validator()->make($request->all(),[
            'user_id' => 'required',
            'address_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $address = DB::table('user_address')
            ->join('city_description', 'city_description.city_id', '=', 'user_address.city_id')
            ->join('area_description', 'area_description.area_id', '=', 'user_address.area_id')
            ->where('user_id', '=', $request->user_id)
            ->where('user_address_id', '=', $request->address_id)
            ->select('user_address_id', 'city_name', 'area_name', 'address_building', 'floor_name', 'street_number', 'landmark')
            ->where('city_description.language_id', '=', $request->language_id)
            ->where('area_description.language_id', '=', $request->language_id)
            ->get();

        if ($address){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $address
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

    public function updateAddress(Request $request) {
        $validator= validator()->make($request->all(),[
            'address_id' => 'required',
            'user_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'address_building' => 'required',
            'floor_name' => 'required',
            'street_number' => 'required',
            'landmark' => 'nullable'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $address = DB::table('user_address')->where('user_address_id', '=', $request->address_id)->first();

        if ($address){
            $update = DB::table('user_address')
                ->where('user_address_id', '=', $request->address_id)
                ->update([
                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id,
                    'user_id' => $request->user_id,
                    'address_building' => $request->address_building,
                    'floor_name' => $request->floor_name,
                    'street_number' => $request->street_number,
                    'landmark' => $request->landmark
                ]);

            $getAddress = DB::table('user_address')
//            ->join('city_description', 'city_description.city_id', '=', 'user_address.city_id')
//            ->join('area_description', 'area_description.area_id', '=', 'user_address.area_id')
                ->where('user_id', '=', $request->user_id)
                ->where('user_address_id', '=', $request->address_id)
                ->select('user_address_id', 'city_id', 'area_id', 'address_building', 'floor_name', 'street_number', 'landmark')
//            ->where('city_description.language_id', '=', $request->language_id)
//            ->where('area_description.language_id', '=', $request->language_id)
                ->first();
            $city = DB::table('city_description')
                ->where('city_id', '=', $getAddress->city_id)
                ->where('language_id', '=', $request->language_id)
                ->select('city_id', 'city_name')
                ->first();
            $getAddress->city = $city;
            $area = DB::table('area_description')
                ->where('area_id', '=', $getAddress->area_id)
                ->where('language_id', '=', $request->language_id)
                ->select('area_id', 'area_name')
                ->first();
            $getAddress->area = $area;

            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $getAddress
            ];
            return response()->json($response);

        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
            return response()->json($response);
        }
    }

    public function deleteAddress(Request $request) {
        $validator= validator()->make($request->all(),[
            'address_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $deleteAddress = DB::table('user_address')->where('user_id', '=', $request->user_id)->where('user_address_id', '=', $request->address_id)->delete();

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => []
        ];
        return response()->json($response);
    }
}
