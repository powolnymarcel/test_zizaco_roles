@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                   {{trans('traduction.youare')}}:  super Admin
                </div>
            </div>



            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @role('super_admin')
                    <p>Zone Visible par le super_admin</p>
                    <div id="no-more-tables">
                        <h3>Nombres d'utilisateurs par roles</h3>
                        <table class="col-md-12 table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th>Super Admin</th>
                                <th>Formateurs</th>
                                <th >Utilisateurs</th>
                                <th >Admin franchise</th>
                                <th >Collaborateur externe</th>
                                <th >Collaborateur interne</th>
                                <th >Partenaire commercial</th>
                                <th >TOTAL utilisateurs</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td data-title="Admin">{{$super_admin}}</td>
                                <td data-title="formateur">{{$formateur}}</td>
                                <td data-title="user">{{$user}}</td>
                                <td data-title="admin_franchise">{{$admin_franchise}}</td>
                                <td data-title="collaborateur_externe">{{$collaborateur_externe}}</td>
                                <td data-title="collaborateur_interne">{{$collaborateur_interne}}</td>
                                <td data-title="partenaire_commercial">{{$partenaire_commercial}}</td>
                                <td data-title="total">{{$totalUtilisateurs}}</td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @endrole
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Recherche : Filtrer par role</div>
                <div class="panel-body">
                    <ul class="list-inline">
                        <li><a href="{{route('super_admin')}}">Tout</a></li>
                        @foreach($roles as $v)
                            <li><a href="{{route('recherche.role',['role'=>$v->name])}}" class="btn btn-default">
                                    {{$v->name }}
                                    @if($v->name == 'user')
                                        {{$user}}
                                    @elseif($v->name == 'formateur')
                                        {{$formateur}}
                                    @elseif($v->name == 'admin_franchise')
                                        {{$admin_franchise}}
                                    @elseif($v->name == 'super_admin')
                                        {{$super_admin}}
                                    @elseif($v->name == 'collaborateur_externe')
                                        {{$collaborateur_externe}}
                                    @elseif($v->name == 'collaborateur_interne')
                                        {{$collaborateur_interne}}
                                    @elseif($v->name == 'partenaire_commercial')
                                        {{$partenaire_commercial}}

                                    @endif
                                </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">Recherche : Filtrer par nom   -- autocomplete AJAX sur base de données USER </div>
                <div class="panel-body">
                    <ul class="list-inline">
                        <form action="{{route('recherche.nom')}}" method="post" class="text-center">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input class="typeahead form-control formControlDisparaitSalorpard" name="nom" style="margin:0px auto;width:300px;" autocomplete="off" type="text">

                            </div>
                            <input type="submit" class="btn btn-default" value="rechercher">
                        </form>
                    </ul>
                </div>
            </div>
            <hr>
            <hr>
            <h2>TABLEAU LARAVEL:</h2>
            <hr>
            <hr>
            <hr>
            <table class="table table-bordered">

                <tr>

                    <th>No</th>

                    <th>Nom</th>

                    <th>Email</th>

                    <th>Roles</th>

                    <th width="280px">Action</th>

                </tr>

                @foreach ($data as $key => $user)

                    <tr>

                        <td>{{ ++$i }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>

                            @if(!empty($user->roles))

                                @foreach($user->roles as $v)


                                    <label class="label  @if($v->name=='user')blue"@elseif($v->name=='formateur')pink"@elseif($v->name=='admin_franchise')grey"@elseif($v->name=='super_admin')gold"@elseif($v->name=='collaborateur_externe')green"@elseif($v->name=='collaborateur_interne')orange"@elseif($v->name=='partenaire_commercial')red"@endif
                                    >{{ $v->name}}</label>

                                @endforeach

                            @endif

                        </td>

                        <td>

                            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Voir</a>
                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Editer</a>
                            <form action="{{route('users.delete',['id'=>$user->id])}}" method="post" style="display: inline">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="btn btn-danger" value="Supprimer">
                            </form>

                        </td>

                    </tr>

                @endforeach

            </table>
            {!! $data->render() !!}
            <hr>
            <hr>
            <h2>TABLEAU VUEJS -> AJAX:</h2>

            <hr>
            <hr>
            <div class="container  tableauVue">
                <div class="col-md-8 col-md-offset-2">
                    <div id="app">
                        <ul class="list-group">
                            <h2>Recherche AJAX dans ce tableau</h2>
                            <input type="text" v-model="searchQuerysurLaPageResultatAffichee">
                            <hr>
                            <button class="btn btn-info" v-on:click="fetchItems()">Recharger resultats</button>
                            <hr>
                            <h2>Recherche AJAX dans tout le tableau de resultats</h2>
                            <input type="text" v-model="searchQuerySurToutLesUser" @keyUp="rechercheUserParticulier(searchQuerySurToutLesUser) | debounce 100">
                            <hr>
                            <li class="list-group-item" v-for="item in items | filterBy searchQuerysurLaPageResultatAffichee ">
                                <a href="/item/@{{ item.id }}">
                                    @{{ item.name }}   <span class="pull-right">@{{ item.email }}</span>
                                </a>
                            </li>
                        </ul>
                        <nav>
                            <ul class="pagination">
                                <li v-if="pagination.current_page > 1">
                                    <a href="#" aria-label="Previous"
                                       @click.prevent="changePage(pagination.current_page - 1)">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber"
                                    v-bind:class="[ page == isActived ? 'active' : '']">
                                    <a href="#"
                                       @click.prevent="changePage(page)">@{{ page }}</a>
                                </li>
                                <li v-if="pagination.current_page < pagination.last_page">
                                    <a href="#" aria-label="Next"
                                       @click.prevent="changePage(pagination.current_page + 1)">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
<pre>
    @{{ $data | json }}
</pre>
                    </div>

                </div>
            </div>
            <hr>
            <hr>
            <hr>
            <hr>
            <hr>
            <hr>

            <div class="panel panel-default">
                <div class="panel-heading">Verifier TVA - Verification AJAX sur le service VIES de la comm européenne</div>
                <div class="panel-body">
                        <ul>
                            <li>Valide : <em>BE0412121524</em></li>
                            <li>Invalide : <em>BE03412121524</em></li>
                        </ul>
                    <input class="form-control" name="vat" id="vat" style="margin:0px auto;width:300px;" type="text">

                </div>
            </div>


        </div>
    </div>
</div>
@section('scripts')
    <script>
    var path = "{{ route('autocomplete') }}";

    $('input.typeahead').typeahead({

        source:  function (query, process) {

            return $.get(path, { query: query }, function (data) {

                return process(data);

            });

        }

    });

    $(document).ready(function(){
        $('#vat').keyup(function () {
            var q=$(this).val();
            if(q.length>7) {

                $.ajax
                ({
                    type: "GET",
                    url: "{{route('vat')}}",
                    data: {vat:q},
                    success: function(data, status, xhr)
                    {
                        console.log(data)
                        if(data == '1'){
                            $( '#vat').css( "border","5px solid #0f0" );
                        }
                        else {
                            $( '#vat').css( "border","5px solid #f00" );
                        }
                    }
                });
            }
        });

    });


    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    Vue.http.options.root = 'http://localhost/zizaco/public';
    //Vue.http.options.root = 'http://ondego.be/doc/laradoc/public/';

    Vue.config.debug = true;
    Vue.config.devtools = true;
    new Vue({
        el: '.tableauVue',
        data: {
            pagination: {
                total: 0,
                per_page: 5,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4,// left and right padding from the pagination <span>,just change it to see effects
            items: []
        },
        ready: function () {
            this.fetchItems(this.pagination.current_page);
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            fetchItems: function (page) {

                var data = {page: page};
                this.$http.get('http://localhost/zizaco/public/users?page='+page).then(function (response) {
                    //look into the routes file and format your response
                    console.info(response)
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);

                }, function (error) {
                    // handle error
                });
            },
            rechercheUserParticulier:function(searchQuerySurToutLeUser){
                this.$http.get('http://localhost/zizaco/public/recherche/user/'+searchQuerySurToutLeUser).then(function (response) {
                    //look into the routes file and format your response
                    console.info(response)
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                }, function (error) {
                    // handle error
                });
            },
            changePage: function (page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            }
        }
    });
    </script>
@endsection
@endsection
