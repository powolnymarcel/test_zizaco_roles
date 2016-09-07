@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @foreach($commandes as $cle=>$commande)
                <div class="panel panel-default">
                    <div class="panel-heading">Commande</div>
                    <div class="panel-body">
                           Reference commande: <strong>TODO : ajouter un champs pour la reference</strong>
                            <br>
                        Commande : {{++$cle}}
                        <br>

                            @foreach($commande->produits()->where('commande_id',$commande->id)->get() as $produit)
                               <ul>
                                   <li> {{$produit->nom}}</li>
                               </ul>
                            @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-md-4">
            </div>
        </div>
    </div>

@endsection
