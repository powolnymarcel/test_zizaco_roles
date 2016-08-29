@extends('layouts.app')



@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2>Editer {{$user->email}}</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('super_admin') }}"> Back</a>

            </div>

        </div>

    </div>

    @if (count($errors) > 0)

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{route('users.update',['id'=>$user->id])}}" method="post">
{{csrf_field()}}
        <input name="_method" type="hidden" value="patch">
        <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Name:</strong>
                <input type="text" placeholder="Name" value="{{$user->name}}" name="name" class="form-control">
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Email:</strong>
                <input type="email" placeholder="email" value="{{$user->email}}" name="email" class="form-control">
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Password:</strong>

                <input type="password" placeholder="Password"  name="password" class="form-control">

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Confirm Password:</strong>

                <input type="password" placeholder="Confirm Password" name="confirm-password" class="form-control">

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Role:</strong>

                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple','size'=>6)) !!}
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </div>

    </form>

@endsection