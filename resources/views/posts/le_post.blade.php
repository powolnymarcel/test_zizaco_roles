@extends('layouts.app')
@section('content')
    @if($lepost->count())

        <div class="container">
        <div class="row">
            <div class="col-md-8 ">
                <div class="panel panel-default animated bounceInDown">
                    <div class="panel-heading">{{trans('traduction.bienvenu')}}</div>

                    <div class="panel-body">
                         <span class="pull-right text-center">
                                   <div class="testCoeur">
                                       <img src="{{asset('img/'.$lepost[0]->user->image)}}" class="img-responsive img-circle avatar" width="80px"  alt="avatar image">
                                       <span class="heartbeat  "> ...</span>

                                   </div>
                                   <h5>{{$lepost[0]->user->name}} <br>via bdd</h5>
                               </span>
                          <span class="pull-right text-center">
                                   <div class="testCoeur">
                                       <img src="{{$lepost[0]->user->avatar()}}" class="img-responsive img-circle avatar" width="80px"  alt="avatar image">                                       <span class="heartbeat  "> ...</span>

                                   </div>
                                   <h5>{{$lepost[0]->user->name}} <br>via gravatar</h5>
                               </span>
                        {{$lepost[0]->contenu}}
                        <br>
                        <small>Test: <br></small>
                        {{$lepost[0]->user->nomEtEmail()}}

                        <p><u>{{trans('traduction.etiquette')}}: </u><br>
                        @foreach($lepost[0]->tags as $tag)
                                <a href="{{route('posts.tag',['tag'=>$tag->slug])}}" class="label label-info"> {{$tag->nom}} </a>
                            @endforeach
                            </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('partials.sidebar')
            </div>
        </div>
    </div>
        @else
        {{trans('traduction.pasDePost')}}
    @endif
@endsection
