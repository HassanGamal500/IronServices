<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function setLangUser(Request $request) {
        $validator = validator()->make($request->all(), [
            'user_id' => 'required',
            'language_id' => 'required',
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

        $set = DB::table('users')->where('id', '=', $request->user_id)->where('service_id', '=', $request->service_id)->update(['default_language' => $request->language_id]);

        $response = [
            'status' => 1,
            'message' => trans('admin.success'),
            'data' => $set
        ];

        return response()->json($response);
    }

    public function page(Request $request) {
        $validator = validator()->make($request->all(), [
            'service_id' => 'required',
            'page_id' => 'required',
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
        $page = DB::table('pages')
            ->join('page_description', 'page_description.page_id', '=', 'pages.page_id')
            ->select('pages.page_id', 'page_description_name', 'page_description_content', 'language_id')
            ->where('pages.page_id', '=', $request->page_id)
            ->where('admin_id', '=', $request->service_id)
            ->where('language_id', '=', $request->language_id)
            ->get();

        $response = [
            'status' => 1,
            'message' => 'successful',
            'data' => $page
        ];

        return response()->json($response);
    }

    public function contactUs(Request $request){
        $validator = validator()->make($request->all(), [
            'user_id' => 'required',
            'subject' => 'required|max:120',
            'message' => 'required',
            'service_id' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response);
        }

        $contact = DB::table('contacts')
            ->insert([
                'contact_subject' => $request->subject,
                'contact_message' => $request->message,
                'user_id' => $request->user_id,
                'admin_id' => $request->service_id
            ]);

        if($contact) {
            $response = [
                'status' => 1,
                'message' => 'successfully',
                'data' => $contact
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => 'successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    // Insert Data JSON into Database
    public function city(){
        $json = file_get_contents(storage_path('data.json'));
        $objs = json_decode($json,true);
        foreach ($objs as $obj)  {
            foreach ($obj as $key => $value) {
                $data = DB::table('cities')->insertGetId([
                    'population' => $value['population'],
                    'location' => $value['location']
                ]);
                DB::table('city_description')->insert([
                    'city_name' => $value['asciiname'],
                    'city_id' => $data,
                    'language_id' => 1
                ]);
            }
        }
        return 'Done';
    }
}
