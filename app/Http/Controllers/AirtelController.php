<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Carbon\Carbon;

class AirtelController extends Controller
{
    public function postpay(Request $request){
        try {
            $amount = $request->input('amount');
            $number = $request->input('number');
            $reference = $request->input('reference');
            // Vérifiez si les champs requis sont présents dans la requête
            if (!$number) {
                return response()->json(["message" => "Veuillez fournir toutes les entrées requises (amount, number)"], 400);
            }

            // Obtenez le token d'authentification auprès du service externe (à partir de .env)
            $response = Http::post(env('tokenUrl'), [
                "client_id" => env('client_id'),
                "client_secret" => env('client_secret'),
                "grant_type" => "client_credentials",
            ]);

            $accessToken = $response->json('access_token');

            // Générez une référence unique pour la transaction
            $rightNow = Carbon::now();
            $yasaiRefTransactionId = "YASAI" . $rightNow->year . '-' . $rightNow->month . '-' . $rightNow->day . '-' . $rightNow->second . '-' . $rightNow->millisecond;

            // Créez les données de la transaction à envoyer à l'API externe
            $transactionData = [
                "reference" => $reference,
                "subscriber" => [
                    "country" => env('COUNTRY'),
                    "currency" => env('ENVCURRENCY'),
                    "msisdn" => $number,
                ],
                "transaction" => [
                    "amount" => $amount,
                    "country" => env('COUNTRY'),
                    "currency" => env('CURRENCY'),
                    "id" => $yasaiRefTransactionId,
                ],
            ];

            // Envoyez la demande à l'API externe avec l'access token
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
                'X-Country' => env('COUNTRY'),
                'X-Currency' => env('CURRENCY'),
                'Authorization' => "Bearer $accessToken",
            ])->post(env('COLLECTION_PAYMENTS_URL'), $transactionData);

            // Créez une transaction dans votre base de données Laravel
            // $transaction = transactionModel::create([
            //     'amount' => $amount,
            //     'number' => $number,
            //     'reference' => $reference,
            //     // 'nb_donakeli' => $nb_donakeli,
            //     // 'creator' => $creatorId,
            //     // 'message' => $message,
            // ]);

            // Réponse de succès avec la réponse de l'API externe et les détails de la transaction créée
            return response()->json([
              "res" => $response->json(),
            //   "tCreated" => $transaction
            ], 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retournez une réponse d'erreur
            return response()->json(["message" => "Une erreur est survenue lors de l'enregistrement"], 500);
        }
    }
}
