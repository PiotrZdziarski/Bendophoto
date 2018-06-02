<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bendophoto') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/homeblade.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Quicksand" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/loginregister.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/UI.css') }}" rel="stylesheet">
</head>
<body style="min-height: 100%; position: relative; box-sizing: border-box; padding-bottom: 40px;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel position-fixed" id="globalnavbar">
            <div class="container">
                <a class="navbar-brand" href="{{ Route('index')}}" style="font-size: 28px;font-family: 'Roboto', sans-serif; color: #444444; padding:0;">
                    {{ config('app.name', 'Bendophoto') }}
                </a>
                @if(isset(Auth::user()->name))
                  <a class="addpost" style="text-decoration: none;" href="{{Route('addingpost')}}">+Add post</a>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown dropdown-toggle" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="font-size: 20px;">
                                    {{ Auth::user()->name }} <span class="caret dropdown-toggle"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{ URL('/') }}" class="profilebuttons" style="margin-left: 5%;">
                                        {{ __('Profile') }}
                                    </a>


                                    <a href="{{ route('logout') }}" class="profilebuttons" style="padding-bottom: 7px; position: absolute; right: 5%;"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer>
      <div class="mainfooter">Bendophoto 2018 &copy Developed by Piotr Zdziarski</div>
    </footer>
</body>
</html>
