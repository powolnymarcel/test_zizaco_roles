<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Produit;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function mon_compte()
    {
        $utilisateur = Auth::user();
        $commandes = Commande::where('user_id',$utilisateur->id)->get();

        //$produitsParCommande =[];
        //foreach ($commandes as $commande)
        //{
        //    array_push($produitsParCommande, $commande->produits()->where('commande_id',$commande->id)->get());
        //}
        return view('moncompte.mon_compte')->withCommandes($commandes);//->withProduitsparcommande($produitsParCommande);
    }
}
