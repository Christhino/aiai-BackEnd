<?php
namespace App\Traits;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Models\SubscriptionVendor;
use App\Models\PaymentMethod;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait MvolaTrait2
{   
   
    public $phoneNumber;
    public function markTransactionAsSuccessful($walletTransaction)
    {
        try {
            DB::beginTransaction();
            
            if (!$walletTransaction->isDirty('status') && $walletTransaction->status == "successful") {
                return;
            }

            $walletTransaction->status = "successful";
            $walletTransaction->save();

            // Mettez à jour le solde du portefeuille
            $wallet = Wallet::find($walletTransaction->wallet->id);
            $wallet->balance += $walletTransaction->amount;
            $wallet->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }
    
    public function createMvolAopupReference($walletTransaction, $paymentMethod) {
       
        
        $apiSecret = env("SMS_GATEWAY");
        
        $ref = Str::random(14);


        $amount = $walletTransaction->amount;

        $walletTransaction->session_id = $ref;
        $walletTransaction->payment_method_id = $paymentMethod->id;
       
    
            $paymentData = [
                "secret" => $apiSecret,
                "code" => "#111*1*1*{$this->phoneNumber}*{$amount}*2009#",
                "sim" => 1, 
                "device" => "00000000-0000-0000-635c-5a760e3b524c",
            ];
    
            $paymentMethod = PaymentMethod::where('slug', "Mvola")->first();
    
            if ($paymentMethod) {
                $cURL = curl_init("https://smstel.aiai.mg/api/send/ussd");
                curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cURL, CURLOPT_POSTFIELDS, $paymentData);
                $response = curl_exec($cURL);
                curl_close($cURL);
    
                $result = json_decode($response, true);
                $walletTransaction->save();

                return route('wallet.topup.callback', ["code" => $walletTransaction->ref, "status" => "success"]);
            } else {
                throw new \Exception("Order is invalid or has already been paid");
            }
        
       
    }

    protected  function  verifyMvolaTopupTransaction($walletTransaction) {

        $paymentMethod = $walletTransaction->payment_method;

        $apiSecret = env("SMS_GATEWAY");

        $cURL = curl_init("https://smstel.aiai.mg/api/get/sms.received?secret={$apiSecret}");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        curl_close($cURL);

        $result = json_decode($response, true);

        $filteredData = array_filter($result['data'], function ($item) {
            return isset($item['sender']) && $item['sender'] === 'MVola';
        });

        foreach ($filteredData as $message) {
            $messageText = $message['message'];

            if (!empty($messageText)) {
                $matches = [];
                if (preg_match('/Le (\d+) a ete debite de (\d+)Ar le (\d{2}\/\d{2}\/\d{2})/', $messageText, $matches)) {
                    $phoneNumber = $matches[1];
                    $amountDebited = (int) $matches[2];
                    $transactionDate = $matches[3];
            
                    if (empty($walletTransaction)) {
                        throw new \Exception("Wallet Topup is invalid");
                    } else if (!$walletTransaction->isDirty('status') && $walletTransaction->status == "successful") {
                        // throw new \Exception("Wallet Topup has already been paid");
                        return;
                    }
            
                    try {
                        DB::beginTransaction();
                        $walletTransaction->status = "successful";
                        $walletTransaction->save();
            
                        // Le reste de votre code de transaction ici
                        $wallet = Wallet::find($walletTransaction->wallet->id);
                        $wallet->balance += $walletTransaction->amount;
                        $wallet->save();
                        DB::commit();
                        return;
                    } catch (\Exception $ex) {
                        throw $ex;
                    }
                }
            }
            
        }
    }
}
