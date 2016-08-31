<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" value="{{csrf_token()}}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        .blue{
            background-color: blue;
        }
.pink{
    background-color: pink;
}
.grey{
    background-color: grey;
}
.gold{
    background-color: gold;
}
.green{
    background-color: green;
}
.orange{
    background-color: orange;
}
.red{
    background-color: red;
}
        @media only screen and (max-width: 800px) {

            /* Force table to not be like tables anymore */
            #no-more-tables table,
            #no-more-tables thead,
            #no-more-tables tbody,
            #no-more-tables th,
            #no-more-tables td,
            #no-more-tables tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            #no-more-tables tr { border: 1px solid #ccc; }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: right;
            }

            #no-more-tables td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align:left;
                font-weight: bold;
            }

            /*
            Label the data
            */
            #no-more-tables td:before { content: attr(data-title); }
        }
        .liProdEnVente{
            margin-bottom: 10px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Vetube's playground
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (!Auth::guest() && Auth::user()->hasRole('super_admin'))

                    <li><a href="{{ url('/super_admin') }}">Super Admin</a></li>
                    @endif
                        @if (!Auth::guest() && Auth::user()->hasRole('formateur'))

                    <li><a href="{{ url('/formateur') }}">formateur</a></li>
                        @endif

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                               Langue <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li class="">
                                        <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                            {{ $localeCode }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container">
    @yield('content')

</div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"  ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.3/vue-resource.min.js"></script>
    <script src="{{asset('js/vuejs-paginator.js')}}"></script>
    @yield('scripts')
</body>
</html>
