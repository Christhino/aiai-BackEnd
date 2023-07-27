<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UssdController  extends Controller
{
    public function getUssdRequest()
    {
        $apiSecret = "3984c142ac77db1461f150c59be2dc3e6c7a2005";

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, "https://smstel.aiai.mg/api/get/ussd?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($response, true);

        return response()->json($result);
    }
}
