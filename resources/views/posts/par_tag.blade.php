@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default animated bounceInDown">
                    <div class="panel-heading">{{trans('traduction.bienvenu')}}</div>

                    <div class="panel-body">
                        <ul class="list-inline nav nav-justified">
                            @foreach($posts as $post)
                                <li class="padbot30">
                                    <img src="{{asset('img/'.$post->image)}}"  class="img img-responsive ">
                                    <h2>{{trans('traduction.titre')}}: {{$post->titre}} </h2>
                               <span class="pull-right text-center">
                                   <div class="testCoeur">
                                       <img src="{{asset('img/'.$post->user->image)}}" class="img-responsive img-circle avatar" width="80px"  alt="avatar image">
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
                                    <p><u>{{trans('traduction.postele')}}: </u><br> {{date('d/m/Y', strtotime($post->datecreation))}}</p>
                                    <p><u>{{trans('traduction.etiquette')}}: </u><br>
                                    @foreach($post->tags as $tag)
                                        <p class="label label-info">{{$tag->slug}}</p>
                                        @endforeach
                                        </p>
                                        <span class="pull-right text-center">
                                 <a href="{{route('lepost',['slug'=>$post->slug])}}" class="btn btn-default lirePlus">Lire plus...</a>
                               </span>
                                </li>
                                <hr>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('partials.sidebar')
            </div>
        </div>
    </div>

    @endsection