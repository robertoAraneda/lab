<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <link href=’https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel=”stylesheet”>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
</head>

<body>
  <div id="el">
    <nav class="navbar navbar-expand-md navbar-light bg-gradient-light shadow-sm">
      <div class="container">

        <a href="{{ url('/') }}" class="brand-link">
          <img src="{{ asset('dist/img/logo-lab.png') }}" alt="Logo Lab HHHA" class="logo-img" style="opacity: .8">
        </a>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">
              Laboratorio clínico HHHA
            </a>
          </li>
        </ul>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
            <li class="nav-item">
              <a class="btn btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
            </li>
            {{-- @if (Route::has('register'))--}}
            {{-- <li class="nav-item">--}}
            {{-- <a class="nav-link btn btn-default" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
            {{-- </li>--}}
            {{-- @endif--}}
            @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('user.infinityTest')  }}" role="button" v-pre> SIEL </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('store.category')  }}" role="button" v-pre> BODEGA </a>
            </li>
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
    <div class="bg-gray-light">
      <v-app>
        @yield('content')
      </v-app>
    </div>


  </div>


  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>