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
        //ON recupere le panier
        $contenuPanier= Cart::content();

        //On indique que la variable $total_a_payer sera de type numérique
        settype($total_a_payer, "integer");

        //ON va chercher le prix réel en base de données
        foreach ($contenuPanier as $itemPanier)
        {
            //On recupere les items un à un
            $item=Produit::where('id','=',$itemPanier->id)->get();

            //On calcule le prix par rapport à la quantité d'item
            $prixEnFonctionDeLaQuantite= ($item[0]->prix) * ($itemPanier->qty);

            //On incrémente le prix total à payer par item
            $total_a_payer += $prixEnFonctionDeLaQuantite;
        }

        //On récupère le montant de la TVA sur la commande  ---- round($test,2)  [$test] pour le montant et [,2] pour 2 chiffres après la virgule
        // [*(21/100)]  POUR 21% de T.V.A.
        //On peut imaginer au lieu de [21] en ecrit ici avoir [$tva] qui serait repris en BDD et modifiable par le backend
        $tvaSurCommande=round($total_a_payer*(21/100),2);

        //On calcule le VRAI total à payer
        $total_a_payer += $tvaSurCommande;

        //bcmul est une extension de BC MATH, permet de convertir le pric en CENTS, en géneral TOUT les services de paiements veulent recevoir un prix indiqué en cents
        $prix_en_cents = bcmul($total_a_payer, 100);


        //Les parametres ADYEN (service de paiement)
        $req = array(
            "action" => "Payment.authorise",
            "paymentRequest.merchantAccount" => "OndegoBE",
            "paymentRequest.amount.currency" => "EUR",
            "paymentRequest.amount.value" => $prix_en_cents,
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
        curl_setopt($ch, CURLOPT_USERPWD, "ws@Company.Ondego:TON_PASSWPRD");
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($req));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        //print_r(($result));
        if($result === false){
            echo "Error: " . curl_error($ch);

        }
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
            //print_r(($result));
            if ($result['paymentResult_resultCode'] =='Refused'){
                //Paiement refuse et autorisé
                echo 0;
            }
            if ($result['paymentResult_resultCode'] =='Authorised'){
                //Paiement accepté et autorisé
                echo 42;
            }


        }

        curl_close($ch);
    }
}
