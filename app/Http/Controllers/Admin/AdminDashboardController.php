<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function home(){
    	$type = auth()->guard('admin')->user()->id;
    	if (auth()->guard('admin')->user()->type == 2) {
    		$users = DB::table('users')->where('service_id', '=', $type)->count();
    		$orders = DB::table('orders')->where('admin_id', '=', $type)->count();
    		$reminders = DB::table('reminders')->where('admin_id', '=', $type)->count();
    		$categories = DB::table('categories')->where('admin_id', '=', $type)->count();
    		$products = DB::table('products')->join('categories', 'categories.category_id', '=', 'products.category_id')->where('admin_id', '=', $type)->count();
    		$brands = DB::table('brands')->where('admin_id', '=', $type)->count();
    		$rates = DB::table('rates')->where('admin_id', '=', $type)->count();
    		return view('admin.dashboard.index')->with([
                'users' => $users,
                'orders' => $orders,
                'reminders' => $reminders,
                'categories' => $categories,
                'products' => $products,
                'brands' => $brands,
                'rates' => $rates
            ]);
     	} else {
            $allServices = DB::table('services')->count();
     		$allUsers = DB::table('users')->count();
    		$allOrders = DB::table('orders')->count();
    		$allReminders = DB::table('reminders')->count();
    		return view('admin.dashboard.index')->with([
                'allServices' => $allServices,
                'users' => $allUsers,
                'orders' => $allOrders,
                'reminders' => $allReminders,
            ]);
     	}
        // return view('admin.dashboard.index');
    }
}
