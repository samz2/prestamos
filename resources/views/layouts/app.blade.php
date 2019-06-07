<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pucallpa Presta</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-image: url('img/fondo1.jpg'); 
background-repeat: no-repeat;
background-size: 100%;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background-color: dimgrey;">
            <div class="container" >
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                Pucallpa Presta
                </a>
                <a class="navbar-brand text-white" href="https://wa.me/51961917071" target="_blank">                    Contacto
                </a>
                <a class="navbar-brand text-white" href="auth.login">
                    Ingresar
                </a>
                <a class="navbar-brand text-white" href="register">
                    Solicitar
                </a>
                <a class="navbar-brand text-white" href="buscar">
                    Consultar
                </a>
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
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li> --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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

        <main class="py-4" >
            @yield('content')
        </main>
    </div>
    <script type="text/javascript">
		<!--
		function filterFloat(evt,input){
			// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
			var key = window.Event ? evt.which : evt.keyCode;    
			var chark = String.fromCharCode(key);
			var tempValue = input.value+chark;
			if(key >= 48 && key <= 57){
				if(filter(tempValue)=== false){
					return false;
				}else{       
					return true;
				}
			}else{
				  if(key == 8 || key == 13 || key == 0) {     
					  return true;              
				  }else if(key == 46){
						if(filter(tempValue)=== false){
							return false;
						}else{       
							return true;
						}
				  }else{
					  return false;
				  }
			}
		}
		function filter(__val__){
			var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
			if(preg.test(__val__) === true){
				return true;
			}else{
			   return false;
			}
			
		}
		-->
		</script>
</body>
</html>