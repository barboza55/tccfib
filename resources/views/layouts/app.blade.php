<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    
    
</head>
<body>
    <div class="container-fluid sticky-top" id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Lima Bauru') }}
            </a>
            <!-- <div class="container"> -->
                <!-- <div class="navbar-header"> -->

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Branding Image -->
                    
                <!-- </div> -->

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Posts</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('posts.index') }}">Listar</a>
                                @can('Create Post', Post::class)
                                <a class="dropdown-item" href="{{ route('posts.create') }}">Novo</a>
                                @endcan
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a  href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vendas</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('sian') }}">Análise</a>
                                @can('Create Post', Post::class)
                                <a class="dropdown-item" href="{{ url('boleto') }}">Retirar Taxa</a>
                                @endcan
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a  href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('apagar') }}">Contas a Pagar</a>
                                @can('Create Post', Post::class)
                                <a class="dropdown-item" href="{{ url('sugestao') }}">Pedido de Compra</a>
                                @endcan
                                <a href="{{ url('comparativo') }}" class="dropdown-item">Comparativo</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a  href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a>
                                @can('Create Post', Post::class)
                                <a class="dropdown-item" href="{{ route('permissions.index') }}">Permissões</a>
                                @endcan
                                <a href="{{ route('roles.index') }}" class="dropdown-item">Funções</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a  href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sian</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('usersian') }}">Conexão</a>
                            </div>
                        </li>
                    </ul>         
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li> 
                        @else
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.index') }}">Admin</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>

                               
                            </li>
                        @endif
                    </ul>
                </div>
            <!-- </div> -->
        </nav>

   </div>
    <div class="container-fluid">
            @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
</body>
</html>
