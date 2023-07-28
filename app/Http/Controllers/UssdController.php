<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UssdController  extends Controller
{
    //ussd  request  
    public function getUssdRequest()
    {
        $apiSecret = env("SMS_GATEWAY");
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, "https://smstel.aiai.mg/api/get/ussd?secret={$apiSecret}");
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
        curl_setopt($cURL, CURLOPT_URL, "https://smstel.aiai.mg/api/get/sms.pending?secret={$apiSecret}");
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
        curl_setopt($cURL, CURLOPT_URL, "https://smstel.aiai.mg/api/get/sms.received?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($response, true);

        return  response()->json($result);
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
        curl_setopt($cURL, CURLOPT_URL, "https://smstel.aiai.mg/api/send/ussd");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $ussdData);
        $response = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($response, true);

        return response()->json($result);
    }
}
