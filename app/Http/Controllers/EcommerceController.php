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

        $total= Cart::total();
        return $total;    }
}
