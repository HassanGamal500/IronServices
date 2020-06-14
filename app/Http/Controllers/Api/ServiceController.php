<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Image;

class ServiceController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function home(Request $request){
        $validator= validator()->make($request->all(),[
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

        $services = DB::table('administration')
//            ->join('services', 'services.service_id', '=', 'administration.service_id')
//            ->join('service_description', 'service_description.service_id', '=', 'services.service_id')
            ->select('id', 'name')
            ->where('id', '=', $request->service_id)
            ->get();

        foreach ($services as $service){
            $banners = DB::table('banners')
                ->where('admin_id', '=', $service->id)
                ->select('banner_image')
                ->get();
            $service->banners = $banners;
            $categories = DB::table('categories')
                ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
                ->where('admin_id', '=', $service->id)
                ->where('language_id', '=', $request->language_id)
                ->select('categories.category_id', 'category_name', 'category_image', 'category_color')
                ->limit(4)
                ->get();
            $service->categories = $categories;
            $products = DB::table('products')
                ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
                ->join('categories', 'categories.category_id', '=', 'products.category_id')
                ->where('language_id', '=', $request->language_id)
                ->where('admin_id', '=', $service->id)
                ->select('products.product_id', 'product_name', 'product_image', 'price', 'discount')
                ->limit(4)
                ->get();
            $service->products = $products;
        }

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $services
        ];
        return response()->json($response);
    }

    public function products(Request $request) {
        $validator= validator()->make($request->all(),[
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

        $products = DB::table('products')
            ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->where('language_id', '=', $request->language_id)
            ->where('admin_id', '=', $request->service_id)
            ->select('products.product_id', 'product_name', 'product_image', 'price', 'discount')
            ->get();

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $products
        ];
        return response()->json($response);
    }

    public function detailProduct(Request $request) {
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $products = DB::table('products')
            ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
            ->join('brand_description', 'brand_description.brand_id', '=', 'products.brand_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            // ->join('product_title', 'product_title.product_id', '=', 'products.product_id')
            // ->join('title_description', 'title_description.title_id', '=', 'product_title.product_title_id')
            ->where('products.product_id', '=', $request->product_id)
            ->where('product_description.language_id', '=', $request->language_id)
            ->where('category_description.language_id', '=', $request->language_id)
            ->where('brand_description.language_id', '=', $request->language_id)
            ->where('admin_id', '=', $request->service_id)
            ->select('products.product_id', 'category_name', 'product_name', 'product_image', 'price',
             'discount', 'brand_name')
            ->get();
        foreach ($products as $product){
            $images = DB::table('product_image')->where('product_id', '=', $request->product_id)->get();
            $product->images = $images;
            $title = DB::table('product_title')
                ->join('title_description', 'title_description.title_id', '=', 'product_title.product_title_id')
                ->where('product_id', '=', $product->product_id)
                ->select('title', 'sub_title')
                ->where('title_description.language_id', '=', $request->language_id)
                ->get();
            $product->titles = $title;
        }

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $products
        ];
        return response()->json($response);
    }

    public function categories(Request $request) {
        $validator= validator()->make($request->all(),[
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

        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('admin_id', '=', $request->service_id)
            ->where('language_id', '=', $request->language_id)
            ->select('categories.category_id', 'category_name', 'category_image', 'category_color')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => $categories
        ];
        return response()->json($response);
    }

    public function category_product(Request $request) {
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
            'category_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $products = DB::table('products')
            ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->where('language_id', '=', $request->language_id)
            ->where('admin_id', '=', $request->service_id)
            ->where('products.category_id', '=', $request->category_id)
            ->select('products.product_id', 'product_name', 'product_image', 'price', 'discount')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => $products
        ];
        return response()->json($response);
    }

    public function makeOrder(Request $request){
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
            'user_id' => 'required',
            'order_detail' => 'required_without:images',
            'address_id' => 'required',
            'images' => 'required_without:order_detail|array',
            'language_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }
//        foreach ($request->images as $key => $value){
//            dd($value['type']);
//        }

        $checkAddress = DB::table('user_address')->where('user_address_id', '=', $request->address_id)->count();

        if($checkAddress > 0) {
            $user = DB::table('users')->where('id', '=', $request->user_id)->select('name', 'email', 'phone')->first();
            $address = DB::table('user_address')->where('user_address_id', '=', $request->address_id)->select('city_id', 'area_id', 'address_building', 'floor_name', 'street_number', 'landmark')->first();
            $city = DB::table('city_description')->where('city_id', '=', $address->city_id)->where('language_id', '=', $request->language_id)->select('city_name')->first();
            $area = DB::table('area_description')->where('area_id', '=', $address->area_id)->where('language_id', '=', $request->language_id)->select('area_name')->first();
            $admin = DB::table('administration')->where('type', '=', 2)->where('id', '=', $request->service_id)->select('name', 'email', 'phone', 'image')->first();

            $order = DB::table('orders')
                ->insertGetId([
                    'order_detail' => $request->order_detail,
                    'address_id' => $request->address_id,
                    'city_name' => $city->city_name,
                    'area_name' => $area->area_name,
                    'address_building' => $address->address_building,
                    'floor_name' => $address->floor_name,
                    'street_number' => $address->street_number,
                    'landmark' => $address->landmark,
                    'status_id' => 1,
                    'admin_id' => $request->service_id,
                    'admin_name' => $admin->name,
                    'admin_email' => $admin->email,
                    'admin_phone' => $admin->phone,
                    'admin_image' => $admin->image,
                    'user_id' => $request->user_id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => $user->phone
                ]);

            $status = DB::table('history_status')
                ->insert([
                    'order_id' => $order,
                    'status_id' => 1
                ]);

            if ($request->images) {
                $images = $request->images;
                if(!array_filter($images) == []){
                    foreach ($images as  $key => $value) {
                        $image = substr($value['image'], strpos($value['image'], ",") + 1);
                        $img = base64_decode($image);

                        $dir="images/order";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            mkdir($dir);
                        }
                        $uploadfile = $dir."/order_".Str::random(60).".jpg";
                        // $resize = Image::make($img)->resize(500, 500)->save(base_path().'/'.$uploadfile);
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $profile_photo = $uploadfile;
                        $insertImage = DB::table('order_image')
                            ->insert([
                                'order_image' => $profile_photo,
                                'type' => $value['type'],
                                'order_id' => $order
                            ]);
                    }
                }
            }

            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.this area is out of reach now, please select another location'),
                'data' => []
            ];
            return response()->json($response);
        } 
    }

    public function orderStatus(Request $request){
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
            'order_id' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $updateStatus = DB::table('orders')
            ->where('order_id', '=', $request->order_id)
            ->update(['status_id' => $request->type]);
        $insertHistory = DB::table('history_status')
            ->insert([
                'order_id' => $request->order_id,
                'status_id' => $request->type
            ]);

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => []
        ];
        return response()->json($response);
    }
}
