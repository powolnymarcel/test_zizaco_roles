@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('traduction.bienvenu')}}</div>

                <div class="panel-body">
                   <ul class="list-inline">

                       @foreach($posts as $post)
                           <li>
                               <h2>{{trans('traduction.titre')}}: {{$post->titre}}</h2>
                               <p>{{trans('traduction.contenu')}} : {{$post->contenu}}</p>
                               <p>{{trans('traduction.auteur')}} : {{$post->user->email}}</p>
                               <p>Roles:
                                   @foreach($post->user->roles as $role)
                                       <label class="label label-success">{{$role->name}}</label>
                                       @endforeach

                               </p>
                               <p>Uuid: {{$post->uuid}}</p>
                           </li>
                           <hr>
                           @endforeach
                   </ul>

                </div>
            </div>
        </div>
<div class="col-md-3" id="produits">
    <div class="panel panel-default">
        <div class="panel-heading"> {{trans('traduction.enVente')}}</div>
        <div class="panel-heading">
        Trier: <br> <button v-on:click="sorting('prix')" class="btn btn-block btn-info">{{trans('traduction.prix')}} @{{ trixPrix }}</button>
            <button v-on:click="sorting('nom')" class="btn btn-block btn-info">{{trans('traduction.nom')}} @{{ trixNom }}</button>
        </div>

        <div class="panel-body">

                <ul>
                    <li v-for="produit in produits "  class="text-left liProdEnVente"><a href="">@{{produit.nom}} <span class="pull-right"><i class="label label-info  ">@{{produit.prix}} €</i></span></a></li>
                </ul>
            <v-paginator :resource.sync="produits"  v-ref:sortingtableauproduits :options="options" :resource_url="resource_url"></v-paginator>

        </div>
    </div></div>
    </div>
</div>
    @section('scripts')
        <script>

            Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
            Vue.http.options.root = 'http://localhost/zizaco/public';
            //Vue.http.options.root = 'http://ondego.be/doc/laradoc/public/';

            Vue.config.debug = true;
            Vue.config.devtools = true;
          vm  =  new Vue({
                el: '#produits',

                data: {
                    produits: [],
                    // here you define the url of your paginated API
                    resource_url: 'http://localhost/zizaco/public/produits/prix/desc',
                    options: {
                        next_button_text: '>>',
                        previous_button_text: '<<',
                        de: '{{trans('traduction.de')}}'
                    },
                    trixPrix:'',
                    trixNom:''
                },
                components: {
                    VPaginator: VuePaginator

                },
                methods: {
                    sorting: function ($leSorting) {
                        if(this.resource_url == 'http://localhost/zizaco/public/produits/'+$leSorting+'/desc')
                        {
                            var url =this.resource_url= 'http://localhost/zizaco/public/produits/'+$leSorting+'/asc';
                            /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$          VOIR INFO  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$!*/
                            vm.$refs.sortingtableauproduits.fetchData(url);
                            if($leSorting == 'prix'){
                                this.trixPrix=': +';
                                this.trixNom='';
                            }
                            else{
                                this.trixPrix='';
                                this.trixNom=': a-z';
                            }
                        }
                        else{
                            var url = this.resource_url= 'http://localhost/zizaco/public/produits/'+$leSorting+'/desc';
                            /* VOIR INFO !*/  vm.$refs.sortingtableauproduits.fetchData(url);
                            if($leSorting == 'prix'){
                                this.trixPrix=': -';
                                this.trixNom='';
                            }
                            else{
                                this.trixPrix='';
                                this.trixNom=': z-a';
                            }
                        }
                    },
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

        </script>
    @endsection
@endsection
