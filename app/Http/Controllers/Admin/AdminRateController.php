<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRateController extends Controller
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
        $type = auth()->guard('admin')->user()->id;
        $rates = DB::table('rates')
            ->join('users', 'users.id', '=', 'rates.user_id')
            ->select('rate_id as id', 'name', 'rate_content as content', 'rate_star as star')
            ->where('admin_id', '=', $type)
            ->orderBy('rate_id', 'desc')
            ->get();
        return view('admin.rates.index', compact('rates'));
    }

    public function destroyRate(Request $request, $id){
        $users = DB::table('rates')
            ->where('rate_id', '=', $id)
            ->delete();
    }
}
