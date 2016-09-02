@if($tags->count())
    <div class="panel panel-default animated bounceInDown">
        <div class="panel-heading"> {{trans('traduction.etiquette')}}</div>
        <div class="panel-body">
            <ul>
                @foreach($tags as $tag)
                    <a href="{{route('posts.tag',['tag'=>$tag->slug])}}"><li class="label label-info">{{$tag->nom}}</li></a>
                @endforeach
            </ul>

        </div>
    </div>

    @else
    {{trans('traduction.notag')}}
    @endif