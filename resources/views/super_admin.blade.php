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

            @role('super_admin')
            <p>Visible par le super_admin</p>
            @endrole

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

                                    <label class="label label-success">{{ $v->name
                                     }}</label>

                                @endforeach

                            @endif

                        </td>

                        <td>

                            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>


                        </td>

                    </tr>

                @endforeach

            </table>

            {!! $data->render() !!}
        </div>
    </div>
</div>
@endsection
