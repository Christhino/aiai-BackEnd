<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

const API_BASE_URL = "https://smstel.aiai.mg/api";


class UssdController  extends Controller
{
    
   

    //ussd  request  
    public function getUssdRequest()
    {
        $apiSecret = env("SMS_GATEWAY");
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_BASE_URL."/get/ussd?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($response, true);


        $filteredData = array_filter($result['data'], function ($item) {
            return isset($item['status']) && $item['status'] === 'queued';
        });

        return response()->json($filteredData);
    }
    //get  pending  message   u request
    public function getSMSRequest() 
    {
        $apiSecret =env("SMS_GATEWAY");
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_BASE_URL."/get/sms.pending?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL); 
        curl_close($cURL);

        $result =json_decode($response,  true);

        return  response()->json($result);
    }

    //get sms received  
    public  function getsmsRedeived()  {
        $apiSecret =env("SMS_GATEWAY");
       
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_BASE_URL."/get/sms.received?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($response, true);
        
        //Filtrer les data
        $filteredData = array_filter($result['data'], function ($item) {
            return isset($item['sender']) && $item['sender'] === 'MVola';
        });
        return response()->json($filteredData);
    }

    //USSD - Send USSD Request
    public function postUssdRequest(Request $request){

        $apiSecret = env("SMS_GATEWAY");
        $amount = $request->input('amount');
        $numero = $request->input('numero');
       
        $ussd = [
            "secret" => $apiSecret,
            "code" => "#111*1*1*{$numero}*{$amount}*2009#",
            "sim" => 1, 
            "device" => "00000000-0000-0000-635c-5a760e3b524c",
        ];
      
        $cURL = curl_init(API_BASE_URL."/send/ussd");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $ussd);
        $response = curl_exec($cURL);
        curl_close($cURL);
    
        $result = json_decode($response, true);
    
        return response()->json($result);
    }

    // Contacts - Get Unsubscribed
    public function  get_unsubscribed() {
        $apiSecret = env("SMS_GATEWAY");

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, "API_BASE_URL./get/groups?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        curl_close($cURL);
      
        $result = json_decode($response, true);
      
    }

    // public  function get_

}
