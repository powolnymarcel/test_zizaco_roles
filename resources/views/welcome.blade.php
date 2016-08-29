@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
    </div>
</div>
@endsection
