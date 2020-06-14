<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    protected $user;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type == 1){
                return redirect('/permission');
            }
            return $next($request);
        });
    }
    
    public function index(){
        $type_id = auth()->guard('admin')->user()->id;
        $banners = DB::table('banners')
            ->select('banner_id as id', 'banner_image as image')
            ->where('admin_id', '=', $type_id)
            ->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function storeBanner(Request $request){
        $validator = validator()->make($request->all(), [
            'banner_image' => 'required|array',
            'banner_image.*' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        if ($request->hasFile('banner_image')) {
            foreach($request->banner_image as $image) {
                $imageName = Storage::disk('edit_path')->putFile('images/banner', $image);
                $img = DB::table('banners')->insert(['banner_image' => $imageName, 'admin_id' => auth()->guard('admin')->user()->id]);
            }
        } else {
            foreach ($request->image as $image) {
                $imageName = 'images/banner/avatar_banner.png';
                $img = DB::table('banners')->insert(['banner_image' => $imageName, 'admin_id' => auth()->guard('admin')->user()->id]);
            }
        }

        $type_id = auth()->guard('admin')->user()->id;
        $banners = DB::table('banners')
            ->select('banner_id as id', 'banner_image as image')
            ->where('admin_id', '=', $type_id)
            ->get();
        $arr=array('status'=>'1','data'=>$banners);
        return response()->json($arr);
    }

    public function editBanner(Request $request) {
        $type_id = auth()->guard('admin')->user()->id;
        $banners = DB::table('banners')
            ->select('banner_id as id', 'banner_image as image')
            ->where('admin_id', '=', $type_id)
            ->where('banner_id', '=', $request->id)
            ->get();
        return response()->json($banners);
    }

    public function updateBanner(Request $request) {
        $validator = validator()->make($request->all(), [
            'banner_image' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $arr=array('status' => '0', 'data' => [], 'message' => $error);
            return response()->json($arr);
        }

        $getImage = DB::table('banners')->where('banner_id', '=', $request->id)->select('banner_image')->first();
        $image = $request->file('banner_image');

//        if ($request->hasFile('banner_image')) {
//            if($getImage->banner_image != 'images/banner/avatar_banner.png'){
//                $myFile = base_path($getImage->image);
//                File::delete($myFile);
//            }
//            $imageName = Storage::disk('edit_path')->putFile('images/banner', $image);
//            $img = DB::table('banners')->where('banner_id', '=', $request->id)->update(['banner_image' => $imageName]);
//        } else {
//            $imageName = $request->old_image;
//            $img = DB::table('banners')->where('banners', '=', $request->id)->update(['banner_image' => $imageName]);
//        }
//
//        $type_id = auth()->guard('admin')->user()->id;
//        $banners = DB::table('banners')
//            ->select('banner_id as id', 'banner_image as image')
//            ->where('admin_id', '=', $type_id)
//            ->get();
//        $arr=array('status'=>'1','data'=>$banners);
        return response()->json($request->all());
    }

    public function destroyBanner(Request $request, $id){
        $getImage = DB::table('banners')->select('banner_image')->where('banner_id', '=', $id)->first();
        if($getImage->banner_image != 'images/admin/avatar_banner.png'){
            $myFile = base_path($getImage->banner_image);
            File::delete($myFile);
        }
        $banners = DB::table('banners')
            ->where('banner_id', '=', $id)
            ->delete();
    }
}
