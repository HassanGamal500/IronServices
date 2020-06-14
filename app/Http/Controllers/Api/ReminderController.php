<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function reminders(Request $request){
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
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

        $reminders = DB::table('reminders')
            ->where('admin_id', '=', $request->service_id)
            ->where('user_id', '=', $request->user_id)
            ->select('reminder_id', 'reminder_title', 'reminder_date', 'reminder_amount')
            ->get();

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $reminders
        ];
        return response()->json($response);
    }

    public function addReminder(Request $request) {
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
            'user_id' => 'required',
            'title' => 'required',
            'date' => 'required',
            'amount' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $reminders = DB::table('reminders')
            ->insertGetId([
                'reminder_title' => $request->title,
                'reminder_date' => $request->date,
                'reminder_amount' => $request->amount,
                'user_id' => $request->user_id,
                'admin_id' => $request->service_id
            ]);

        $getReminder = DB::table('reminders')
            ->where('reminder_id', '=', $reminders)
            ->where('admin_id', '=', $request->service_id)
            ->where('user_id', '=', $request->user_id)
            ->select('reminder_id', 'reminder_title', 'reminder_date', 'reminder_amount')
            ->first();

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $getReminder
        ];
        return response()->json($response);
    }

    public function cancelReminder(Request $request){
        $validator= validator()->make($request->all(),[
            'service_id' => 'required',
            'reminder_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $cancelReminder = DB::table('reminders')->where('reminder_id', '=', $request->reminder_id)->delete();

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $cancelReminder
        ];
        return response()->json($response);
    }
}
