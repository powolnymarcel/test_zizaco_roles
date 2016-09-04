<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Produit;
use Cart;

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






    }
