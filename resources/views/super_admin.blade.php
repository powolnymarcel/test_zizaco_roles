@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                   Vous etes super Admin
                </div>
            </div>



            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @role('super_admin')
                    <p>Zone Visible par le super_admin</p>
                    @endrole
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Filtrer</div>

                <div class="panel-body">
                    <ul class="list-inline">
                        @foreach($roles as $v)
                            <li><a href="{{route('recherche.role',['role'=>$v->name])}}" class="btn btn-default">{{ $v->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <table class="table table-bordered">

                <tr>

                    <th>No</th>

                    <th>Name</th>

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

                            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                            <form action="{{route('users.delete',['id'=>$user->id])}}" method="post" class="form-inline">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="btn btn-danger" value="Supprimer">
                            </form>

                        </td>

                    </tr>

                @endforeach

            </table>

            {!! $data->render() !!}
        </div>
    </div>
</div>
@endsection
