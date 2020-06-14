<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomersPush extends Controller
{
    public function send($title='', $message='',$registration_ids='',$type='',$status='', $checkUser='', $order_id='') {
        if($checkUser == ''){
            // $data=array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000));
    
            if($type==''){
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'sound'=>'default'),
                    'data' => array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000)),
                    'registration_ids' => $registration_ids,
                    //'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }/*else{
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'status' => $status,'sound' => 'default', 'server_time'=>round(microtime(true) * 1000), 'badge' => '1'),
                    'data' => $data,
                    //'registration_ids' => $registration_ids,
                    'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }*/
            return $this->sendPushNotification($fields);
        } elseif($checkUser == '2') {
            // $data=array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000), 'api_action' => 'forceLogout');
    
            if($type==''){
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'sound'=>'default'),
                    'data' => array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000), 'api_action' => 'forceLogout'),
                    'registration_ids' => $registration_ids,
                    //'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }/*else{
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'status' => $status,'sound' => 'default', 'server_time'=>round(microtime(true) * 1000), 'badge' => '1', 'api_action' => 'forceLogout'),
                    'data' => $data,
                    //'registration_ids' => $registration_ids,
                    'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }*/
            return $this->sendPushNotification($fields);
        } else {
            if($type==''){
                $fields = array(
                    'notification' => array('title' => $title ,'body' => $message,'sound'=>'default'),
                    'data' => array("click_action"=>"FLUTTER_NOTIFICATION_CLICK",'status'=>$status,'sound'=>'default', 'server_time'=>round(microtime(true) * 1000), 'order' => $order_id),
                    'registration_ids' => $registration_ids,
                    //'to'=>'/topics/all',
                    'priority' => 'high'
                );
            }
            return $this->sendPushNotification($fields);
        }
            
    }
    
    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent 
    */
    private function sendPushNotification($fields) {
        
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        //building headers for the request
        $headers = array(
            'Authorization: key=AAAAZ9ffPE8:APA91bFOrMb8Jd-1ZZM2nn-531_6_vxyw6Ozyv3DtpoQRwSEsxT6E-y40i8lay3Ta0WCZNkHbyTsIWeWqe2koJwevnn2f5A4znZHKfs3rvRZqBFEBV61R_7HIYncMC7OjOd8aRvH40vI',
            'Content-Type: application/json'
        );
 
        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        return $result;
    }
}
