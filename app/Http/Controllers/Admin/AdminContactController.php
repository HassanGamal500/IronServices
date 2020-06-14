<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminContactController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type == 2){
                return redirect('/permission');
            }
            return $next($request);
        })->only('showAllAdmin', 'getContactsAdmin', 'contact_notifyAdmin');

        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user()->type;
            if(auth()->guard('admin')->user()->type == 1){
                return redirect('/permission');
            }
            return $next($request);
        })->except('showAllAdmin', 'getContactsAdmin', 'contact_notifyAdmin');
    }

    public function index(){
        return view('admin.contact.contactUs');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'contact_subject' => 'required',
            'contact_message' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $coupon = DB::table('contact_irondot')
            ->insert([
                'contact_subject' => $request->contact_subject,
                'contact_message' => $request->contact_message,
                'admin_id' => auth()->guard('admin')->user()->id
            ]);

        $message = session()->get('locale') == 'ar' ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function showAllAdmin(){
        $contacts = DB::table('contact_irondot')
            ->select('contact_id as id', 'contact_subject as name', 'contact_message as message')
            ->orderBy('contact_id', 'desc')
            ->get();
        $readAll = DB::table('contact_irondot')->update(['contact_read' => 1]);
        return view('admin.contact.indexAdmin', compact('contacts'));
    }

    public function showAll(){
        $type = auth()->guard('admin')->user()->id;
        $contacts = DB::table('contacts')
            ->select('contact_id as id', 'contact_subject as name', 'contact_message as message')
            ->where('admin_id', '=', $type)
            ->orderBy('contact_id', 'desc')
            ->get();
        $readAll = DB::table('contacts')->where('admin_id', '=', $type)->update(['contact_read' => 1]);
        return view('admin.contact.index', compact('contacts'));
    }

    public function getContacts(){
        $type = auth()->guard('admin')->user()->id;
        $contacts = DB::table('contacts')->where('admin_id', '=', $type)->where('contact_read', '=', 0)->orderBy('contact_id', 'desc')->count();
        return response()->json($contacts);
    }

    public function contact_notify(){
        $type = auth()->guard('admin')->user()->id;
        $contacts = DB::table('contacts')->where('admin_id', '=', $type)->where('notify_read', '=', 0)->count();
        $update = DB::table('contacts')->where('admin_id', '=', $type)->where('notify_read', '=', 0)->update(['notify_read' => 1]);
        return response()->json($contacts);
    }

    public function getContactsAdmin(){
        $contacts = DB::table('contact_irondot')->where('contact_read', '=', 0)->orderBy('contact_id', 'desc')->count();
        return response()->json($contacts);
    }

    public function contact_notifyAdmin(){
        $contacts = DB::table('contact_irondot')->where('notify_read', '=', 0)->count();
        $update = DB::table('contact_irondot')->where('notify_read', '=', 0)->update(['notify_read' => 1]);
        return response()->json($contacts);
    }

    public function destroyContact(Request $request, $id){
        $contacts = DB::table('contacts')
            ->where('contact_id', '=', $id)
            ->delete();
    }
}
