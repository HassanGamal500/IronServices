<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminReminderController extends Controller
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
        $remindersNow = DB::table('reminders')
            ->join('users', 'users.id', '=', 'reminders.user_id')
            ->select('reminder_id as id', 'reminder_title', 'reminder_date', 'reminder_amount', 'name')
            ->where('admin_id', '=', $type)
            ->whereDate('reminder_date', now()->toDateString())
            ->orderBy('reminder_date', 'asc')
            ->get();
        $remindersThree = DB::table('reminders')
            ->join('users', 'users.id', '=', 'reminders.user_id')
            ->select('reminder_id as id', 'reminder_title', 'reminder_date', 'reminder_amount', 'name')
            ->where('admin_id', '=', $type)
            ->whereBetween('reminder_date', [now()->toDateString() ,now()->addDays(3)->toDateString()])
            ->orderBy('reminder_date', 'asc')
            ->get();
        $remindersSeven = DB::table('reminders')
            ->join('users', 'users.id', '=', 'reminders.user_id')
            ->select('reminder_id as id', 'reminder_title', 'reminder_date', 'reminder_amount', 'name')
            ->where('admin_id', '=', $type)
            ->whereBetween('reminder_date', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->orderBy('reminder_date', 'asc')
            ->get();
        return view('admin.reminders.index', compact('remindersNow', 'remindersThree', 'remindersSeven'));
    }
}
