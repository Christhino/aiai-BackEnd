<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        return response()->json($result);
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

        $ussdData = [
            "secret" => $apiSecret,
            "code" => $request->input('code'),
            "sim" => $request->input('sim'),
            "device" => $request->input('device')
        ];

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, API_BASE_URL."/send/ussd");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $ussdData);
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

}
