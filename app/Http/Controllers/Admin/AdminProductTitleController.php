<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminProductTitleController extends Controller
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

    public function index($id){
        $type_id = auth()->guard('admin')->user()->id;
        $titles = DB::table('product_title')
            ->join('title_description', 'title_description.title_id', '=', 'product_title.product_title_id')
            ->join('products', 'products.product_id', '=', 'product_title.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->select('product_title_id as id', 'title', 'sub_title')
            ->where('title_description.language_id', '=', language())
            ->where('admin_id', '=', $type_id)
            ->where('product_title.product_id', '=', $id)
            ->orderBy('product_title_id', 'desc')
            ->get();
        return view('admin.product_title.index', compact('titles', 'id'));
    }

    public function addTitle($id){
        $type_id = auth()->guard('admin')->user()->id;
        return view('admin.product_title.create', compact('id'));
    }

    public function storeTitle(Request $request) {
        $validator = validator()->make($request->all(), [
            'title' => 'required|max:70',
            'sub_title' => 'required|max:140',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->title[1])
        && preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->sub_title[1])
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->title[2])
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->sub_title[2])) {
            $title = DB::table('product_title')
                ->insertGetId(['product_id' => $request->product_id]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('title_description')
                    ->insert([
                        'title' => $request->title[$i],
                        'sub_title' => $request->sub_title[$i],
                        'language_id' => $i,
                        'title_id' => $title
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->title[1]) && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->sub_title[1])) {
                $error = trans('admin.title or sub title must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = App::isLocale('ar') ? 'تم الاضافه بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function editTitle($id){
        $type_id = auth()->guard('admin')->user()->id;
        $titles = DB::table('product_title')
            ->join('title_description', 'title_description.title_id', '=', 'product_title.product_title_id')
            ->select('product_title_id as id', 'title', 'sub_title', 'product_id')
            ->where('product_title_id', '=', $id)
            ->orderBy('product_title_id', 'desc')
            ->get();
//        $products = DB::table('products')
//            ->join('product_description', 'product_description.product_id', '=', 'products.product_id')
//            ->join('categories', 'categories.category_id', '=', 'products.category_id')
//            ->where('language_id', '=', language())
//            ->where('admin_id', '=', $type_id)
//            ->select('products.product_id as id', 'product_name as name')
//            ->get();
// dd($titles);
        return view('admin.product_title.edit', compact('titles'));
    }

    public function updateTitle(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'title' => 'required|max:70',
            'sub_title' => 'required|max:140',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->title[1])
        && preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->sub_title[1])
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->title[2])
        && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->sub_title[2])) {
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('title_description')
                    ->where('language_id', '=', $i)
                    ->where('title_id', '=', $id)
                    ->update([
                        'title' => $request->title[$i],
                        'sub_title' => $request->sub_title[$i],
                    ]);
            }
        } else {
            if(preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->title[1]) && preg_match("/^[\p{Arabic}\s\p{N}_.,{}@#!~%()<>-]+$/u", $request->sub_title[1])) {
                $error = trans('admin.title or sub title must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        $message = App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroyTitle(Request $request, $id){
        $service = DB::table('product_title')
            ->where('product_title_id', '=', $id)
            ->delete();
    }
}
