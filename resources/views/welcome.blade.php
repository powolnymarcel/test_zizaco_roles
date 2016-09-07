@extends('layouts.app')

@section('content')
    <div class="container zoneAchat">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <table class="table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                    <tr>
                        <th>{{trans('traduction.produit')}}</th>
                        <th>{{trans('traduction.quantite')}}</th>
                        <th class="numeric">{{trans('traduction.prix')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in tableauPanier[0]">
                        <td data-title="Produit">@{{ item.name }}</td>
                        <td data-title="Quantitée">@{{ item.qty }}</td>
                        <td data-title="SousTotal" class="numeric">@{{ item.price }}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>SousTotal</td>
                        <td>@{{ tableauPanier[1] }}</td>
                    </tr>
                    <tr>
                        <td>TVA</td>
                        <td>@{{ tableauPanier[2] }}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>@{{ tableauPanier[3] }}</td>
                    </tr>
                    </tfoot>
                </table>
                <div class="panel panel-default animated bounceInDown">
                    <div class="panel-heading">{{trans('traduction.bienvenu')}}</div>

                    <div class="panel-body">
                        <ul class="list-inline nav nav-justified">
                            @if($posts->count())
                                @foreach($posts as $post)
                                    <li class="padbot30">
                                        <img src="{{asset('img/'.$post->image)}}" class="img img-responsive ">
                                        <h2>{{trans('traduction.titre')}}: {{$post->titre}} </h2>
                               <span class="pull-right text-center">
                                   <div class="testCoeur">
                                       <img src="{{asset('img/'.$post->user->image)}}"
                                            class="img-responsive img-circle avatar" width="80px" alt="avatar image">
                                       <span class="heartbeat  "> ...</span>

                                   </div>
                                   <h5>{{$post->user->name}}</h5>
                               </span>
                                        <p><u>{{trans('traduction.contenu')}} :</u><br> {{$post->contenu}}</p>
                                        <p><u>{{trans('traduction.auteur')}} :</u><br> {{$post->user->email}}</p>
                                        <p><u>Roles:</u><br>
                                            @foreach($post->user->roles as $role)
                                                <label class="label label-success">{{$role->name}}</label>
                                            @endforeach

                                        </p>
                                        <p><u>Uuid:</u><br> {{$post->uuid}}</p>
                                        <p><u>{{trans('traduction.postele')}}
                                                : </u><br> {{date('d/m/Y', strtotime($post->datecreation))}}</p>
                                        <p><u>{{trans('traduction.etiquette')}}: </u><br>
                                            @foreach($post->tags as $tag)
                                                <a href="{{route('posts.tag',['tag'=>$tag->slug])}}"
                                                   class="label label-info"> {{$tag->nom}} </a>

                                            @endforeach
                                        </p>
                           <span class="pull-right text-center">
                                 <a href="{{route('lepost',['slug'=>$post->slug])}}" class="btn btn-default lirePlus">Lire
                                     plus...</a>
                               </span>
                                    </li>
                                    <hr>

                                @endforeach
                            @else
                                {{trans('traduction.pasDePost')}}
                            @endif
                        </ul>

                    </div>
                </div>
            </div>

            <div class="col-md-3" id="panier">
                <div class="panel panel-default animated bounceInRight">
                    <div class="panel-heading">{{trans('traduction.panier')}}</div>
                    <div class="panel-body">

                        Total : @{{ tableauPanier[3]}}
                        <div v-show="btn_achat" class="btn btn-success" data-toggle="modal"
                             data-target="#myModal">{{trans('traduction.payer')}}</div>

                    </div>
                </div>
            </div>
            <div class="col-md-3" id="produits">
                <div class="panel panel-default animated bounceInRight">
                    <div class="panel-heading"> {{trans('traduction.enVente')}}</div>
                    <div class="panel-heading">
                        {{trans('traduction.trier')}}: <br>
                        <button v-on:click="sorting('prix')"
                                class="btn btn-block btn-default">{{trans('traduction.prix')}} @{{ trixPrix }}</button>
                        <button v-on:click="sorting('nom')"
                                class="btn btn-block btn-default ">{{trans('traduction.nom')}} @{{ trixNom }}</button>
                    </div>

                    <div class="panel-body">

                        <ul>
                            <li v-for="produit in produits " class="text-left liProdEnVente">
                                <a href="#">@{{produit.nom}}
                                    <span class="pull-right">
                                <i class="label label-info  ">@{{produit.prix}} €</i>&nbsp;
                                <button class="btn btn-success btn-sm" :disabled="boutonsDesactive"
                                        @click.prevent="ajoutPanier(produit.id)">+
                                </button>
                            </span>
                                </a></li>
                        </ul>
                        <v-paginator :resource.sync="produits" v-ref:sortingtableauproduits :options="options"
                                     :resource_url="resource_url"></v-paginator>

                    </div>
                </div>

                <hr>
                @include('partials.sidebar')
                @include('partials.modalpaiement2')
            </div>
            <div class="col-md-3" id="panier">
                <div class="panel panel-default animated bounceInRight">
                    <div class="panel-heading">Shortcuts</div>
                    <div class="panel-body">
                        <a href="{{route('destructionsession')}}" class="btn btn-block btn-danger">Flush de la
                            session</a>
                        <a href="{{route('logs')}}" class="btn btn-block btn-default">Logs</a>
                        <a href="{{route('resetlogs')}}" class="btn btn-block btn-warning">Reset Logs</a>
                        <a href="{{route('phpinfo')}}" class="btn btn-block btn-info">phpinfo()</a>


                    </div>
                </div>
            </div>
        </div><!-- FIN ROW -->
    </div><!-- FIN CONTAINER -->
@section('styles')
    <link rel="stylesheet" href="lib/toastr/toastr.min.css">
@endsection
@section('scripts')
    <script src="lib/toastr/toastr.min.js"></script>
    <script src="https://test.adyen.com/hpp/cse/js/7614570506780374.shtml"></script>
    <script type="text/javascript">
        // the form element to encrypt
        var form = document.getElementById('adyen-encrypted-form');
        // See adyen.encrypt.simple.html for details on the options to use
        var options = {};

        // Create the form.
        // Note that the method is on the Adyen object, not the adyen.encrypt object.
        adyen.createEncryptedForm(form, options);
    </script>
    <script>

        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        Vue.http.options.root = 'http://localhost/zizaco/public';
        //Vue.config.debug = true;
        //Vue.config.devtools = true;

        vm = new Vue({
            el: '.zoneAchat',

            data: {
                produits: [],
                // here you define the url of your paginated API
                resource_url: 'http://localhost/zizaco/public/produits/prix/desc',
                options: {
                    next_button_text: '>>',
                    previous_button_text: '<<',
                    de: '{{trans('traduction.de')}}'
                },
                trixPrix: '',
                trixNom: '',
                boutonsDesactive: false,
                btn_achat: false,
            },
            ready: function () {
                //alert('Everything is working fine!');
                this.recupererPanierSousFormeDeTableau();
            },
            components: {
                VPaginator: VuePaginator

            },
            methods: {
                sorting: function ($leSorting) {
                    if (this.resource_url == 'http://localhost/zizaco/public/produits/' + $leSorting + '/desc') {
                        var url = this.resource_url = 'http://localhost/zizaco/public/produits/' + $leSorting + '/asc';
                        /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$          VOIR INFO  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$!*/
                        vm.$refs.sortingtableauproduits.fetchData(url);
                        if ($leSorting == 'prix') {
                            this.trixPrix = ': +';
                            this.trixNom = '';
                        }
                        else {
                            this.trixPrix = '';
                            this.trixNom = ': a-z';
                        }
                    }
                    else {
                        var url = this.resource_url = 'http://localhost/zizaco/public/produits/' + $leSorting + '/desc';
                        /* VOIR INFO !*/
                        vm.$refs.sortingtableauproduits.fetchData(url);
                        if ($leSorting == 'prix') {
                            this.trixPrix = ': -';
                            this.trixNom = '';
                        }
                        else {
                            this.trixPrix = '';
                            this.trixNom = ': z-a';
                        }
                    }
                },
                recupererPanierSousFormeDeTableau: function () {
                    this.$http.get('recuperation/tableau/panier')
                            .then(function (data) {
                                        //console.log("Recuperation compétences OK");
                                        //console.log(data);
                                        this.$set('tableauPanier', data.data);
                                        //this.competences= data.data;
                                        console.log(this.tableauPanier);
                                        if (parseInt(this.tableauPanier[3]) > 0) {
                                            vm.btn_achat = true;
                                        }
                                        console.log("Recuperation tableauPanier  OK");
                                    }.bind(this),
                                    function (data) {
                                        console.log("Recuperation tableauPanier PAS OK");
                                        console.log(data);

                                    });
                },
                //recupererTotalPanier:function(){
                //    this.$http.get('recuperation/total/panier')
                //            .then(function(data){
                //                        //console.log("Recuperation compétences OK");
                //                        //console.log(data);
                //                        this.$set('panier', data.data);
                //                        //this.competences= data.data;

                //                    },
                //                    function(data){
                //                        console.log("Recuperation panier PAS OK");
                //                        console.log(data);

                //                    });
                //},
                ajoutPanier: function (id) {
                    //event.preventDefault()

                    //var boutonCible =event.target;
                    //boutonCible.setAttribute("disabled", "disabled");
                    vm.boutonsDesactive = true;
                    vm.btn_achat = true;

                    var id = {
                        'id': id
                    };
                    Vue.http.post('ajout/produit', id).then(function (response) {
                        console.log('ok');
                        //toastr.success('Parcours modifié', 'ONDEGO ADMIN');
                        toastr.success('Ajout bien effectué', 'ONDEGO');
                        vm.boutonsDesactive = false;
                        //boutonCible.removeAttribute("disabled", "disabled");
                        this.$set('panier', response.data[0]);
                        this.$set('tableauPanier', response.data)

                        //vm.recupererTotalPanier();
                        //vm.recupererPanierSousFormeDeTableau();

                    }.bind(this), function (response) {
                        console.log('pas ok');
                        var reponseServeur = response;
                        //Si plusieurs rreurs on boucle sur les erreur et on affiche un toastr par erreur
                        // for(var index in reponseServeur) {
                        //     var attr = reponseServeur[index];
                        //     toastr.warning(attr, 'ONDEGO ADMIN');
                        // }

                    });
                }
            }
        });
        //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$      INFO          $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

        // PAGINATION VUEJS AVEC les chiffres des pages 1,2,3,4,.....
        //----->>>>< https://github.com/JellyBool/laravel-vue-pagination
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //!!!!!ATTENTION LE PLUGIN  vuejs-paginator.js  A ETE MODIFIE !!!!!
        //data.config.de   pour permettre une traduction de "page n OF n "!
        //Le html avec l'ajout de classes!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        //In the end I opted for using Vue's v-ref directive. This allows a component to be referenced from the parent for direct access.
        //
        //E.g.
        //
        //Have a compenent registered on my parent instance:
        //
        //var vm = new Vue({
        //    el: '#app',
        //    components: { myComponent: 'my-component' }
        //});
        //
        //Render the component in template/html with a reference:
        //
        //<my-component v-ref:foo></my-component>
        //
        //Now, elsewhere I can access the component externally
        //
        //<script>
        //vm.$refs.foo.doSomething(); //assuming my component has a doSomething() method
        //<\/script>


        //$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$      DUMB INFO          $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


        // AU début j'avais fais deux méthodes   sortingPrix      et  sortingNom    mais en respectant le D.R.Y. j'ai pu facilement créer une méthode        sorting  qui reçoit en parametre le pric ou le nom à trier

        //
        //                    //Permet de relancer le component et de lui envoyer la nouvelle URL de tri !
        //                    sortingPrix: function () {
        //                        if(this.resource_url == 'http://localhost/zizaco/public/produits/prix/desc')
        //                            {
        //                                var url =this.resource_url= 'http://localhost/zizaco/public/produits/prix/asc';
        //                                /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$          VOIR INFO  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$!*/
        //                                vm.$refs.sortingtableauproduits.fetchData(url);
        //                                this.trixPrix='+';
        //                                this.trixNom='';
        //
        //                            }
        //                        else{
        //                            var url = this.resource_url= 'http://localhost/zizaco/public/produits/prix/desc';
        //                            /* VOIR INFO !*/  vm.$refs.sortingtableauproduits.fetchData(url);
        //                            this.trixPrix='-';
        //                            this.trixNom='';
        //
        //                        }
        //                    },
        //                    sortingNom: function () {
        //                        if(this.resource_url == 'http://localhost/zizaco/public/produits/nom/desc')
        //                        {
        //                            var url =this.resource_url= 'http://localhost/zizaco/public/produits/nom/asc';
        //                            /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$          VOIR INFO  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$!*/
        //                            vm.$refs.sortingtableauproduits.fetchData(url);
        //                            this.trixNom='a-z';
        //                            this.trixPrix='';
        //
        //                        }
        //                        else{
        //                            var url = this.resource_url= 'http://localhost/zizaco/public/produits/nom/desc';
        //                            /* VOIR INFO !*/  vm.$refs.sortingtableauproduits.fetchData(url);
        //                            this.trixNom='z-a';
        //                            this.trixPrix='';
        //
        //                        }
        //                    },


        $(".testCoeur").hover(
                function () {
                    $(".avatar").addClass('animated jello ');
                },
                function () {
                    $(".avatar").removeClass('animated jello ');
                }
        );
        $(".lirePlus").hover(
                function () {
                    $(this).addClass('animated flash infinite ');
                },
                function () {
                    $(this).removeClass('animated flash infinite');
                }
        );


    </script>
@endsection

@endsection
