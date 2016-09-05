<?php

namespace App\Http\Controllers;

use Adyen\Service;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Produit;
use Cart;
use Illuminate\Support\Facades\Session;

class EcommerceController extends Controller
{

    public function recupererTotalPanier(){
        $total= Cart::total();
        return $total;
    }

    public function panierSousFormeDeTableau(){
        $contenuPanier = Cart::content();
//dd($contenuPanier);
        $cartSubtotal = Cart::subtotal() ;
        $cartTax = Cart::tax();
        $cartTotal = Cart::total(); 
        $reponse =[$contenuPanier,$cartSubtotal,$cartTax,$cartTotal];
        return $reponse;

    }


    public function ajoutProduitPanier(Request $request){
        $leProduit=Produit::where('id','=',$request->id)->first();
        Cart::add([ 'id' => $leProduit->id,
            'name' => $leProduit->nom,
            'qty' => 1,
            'price' => $leProduit->prix]);
        $contenuPanier = Cart::content();
        $cartSubtotal = Cart::subtotal() ;
        $cartTax = Cart::tax();
        $total= Cart::total();
        $reponse =
            [$contenuPanier,
                $cartSubtotal,
                $cartTax,
                $total];
        return response()->json($reponse, 200);
       // $reponse =
       //     [   'contenuPanier'=>$contenuPanier,
       //         'cartSubtotal'=>$cartSubtotal,
       //         'cartTax'=>$cartTax,
       //         'total'=>$total];
    }



    public function verficationPaiement(Request $request)
    {

        $req = array(
            "action" => "Payment.authorise",
            "paymentRequest.merchantAccount" => "OndegoBE",
            "paymentRequest.amount.currency" => "EUR",
            "paymentRequest.amount.value" => "199",
            "paymentRequest.reference" => "TEST-PAYMENT-" . date("Y-m-d-H:i:s"),
            "paymentRequest.shopperIP" => "ShopperIPAddress",
            "paymentRequest.shopperEmail" => "TheShopperEmailAddress",
            "paymentRequest.shopperReference" => "YourReference",
            "paymentRequest.fraudOffset" => "0",
            "paymentRequest.additionalData.card.encrypted.json" => $request['adyen-encrypted-data']
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
        curl_setopt($ch, CURLOPT_USERPWD, "ws@Company.Ondego:TON_PASSWORD");
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($req));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if($result === false)
            echo "Error: " . curl_error($ch);
        else{
            /**
             * If the payment passes validation a risk analysis will be done and, depending on the
             * outcome, an authorisation will be attempted. You receive a
             * payment response with the following fields:
             * - pspReference: The reference we assigned to the payment;
             * - resultCode: The result of the payment. One of Authorised, Refused or Error;
             * - authCode: An authorisation code if the payment was successful, or blank otherwise;
             * - refusalReason: If the payment was refused, the refusal reason.
             */
            parse_str($result,$result);
            print_r(($result));
        }

        curl_close($ch);
    }
}
