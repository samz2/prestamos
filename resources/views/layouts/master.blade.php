<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pucallpa Presta</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	{{-- <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css"> --}}
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  {{-- <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> --}}
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  {{-- <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> --}}
</head>
<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper" id="app">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
				</li>
			</ul>
    
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Messages Dropdown Menu -->
				<li class="nav-item dropdown">
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						@switch(Auth::user()->tipo)
							@case(1)
								Administrador <span class="caret"></span>	
								@break
							@case(2)
								Usuario <span class="caret"></span>	
								@break
							@default
								
						@endswitch
						{{-- {{ Auth::user()->user }} <span class="caret"></span> --}}
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
										  document.getElementById('logout-form').submit();">
							 {{ __('Cerrar Sesión') }}
						 </a>

						 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							 @csrf
						 </form>
					</div>
				</li>
			</ul>
		</nav>
    
		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 600px;">
			<!-- Brand Logo -->
			<router-link to="/home" class="brand-link text-center">
				<span class="brand-text font-weight-light">Pucallpa Presta</span>
			</router-link>
    
			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				{{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block">User</a>
					</div>
				</div> --}}
    
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						@switch(Auth::user()->tipo)
							@case(1)
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fa fa-folder"></i>
									<p>
										Menu
										<i class="fa fa-angle-right right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/clientes" class="nav-link">
											<i class="fa fa-user nav-icon"></i>
											<p>Clientes</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/prestamos" class="nav-link">
											<i class="fa fa-dollar nav-icon"></i>
											<p>Prestamos</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/pago" class="nav-link">
											<i class="fa fa-dollar nav-icon"></i>
											<p>Pagos</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/solicitudes" class="nav-link">
											<i class="fa fa-list nav-icon"></i>
											<p>solicitudes</p>
										</router-link>
									</li>
								</ul>
							</li>
							{{-- <li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fa fa-folder" aria-hidden="true"></i>
									<p>
										Reportes
										<i class="fa fa-angle-right right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/reserva" class="nav-link">
											<i class="fa fa-ticket nav-icon" aria-hidden="true"></i>
											<p>Caja</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/ticket" class="nav-link">
											<i class="fa fa-ticket nav-icon" aria-hidden="true"></i>
											<p>Prestamos</p>
										</router-link>
									</li>
									<li class="nav-item">
											<router-link to="/pago" class="nav-link">
												<i class="fa fa-ticket nav-icon" aria-hidden="true"></i>
												<p>Pagos</p>
											</router-link>
										</li>
								</ul> --}}
							</li>
							@break
							@case(2)
								<li class="nav-item has-treeview">
									<a href="#" class="nav-link">
										<i class="nav-icon fa fa-folder" aria-hidden="true"></i>
										<p>
											Mostrar
											<i class="fa fa-angle-left right"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<router-link to="/visualize" class="nav-link">
												<i class="fa fa-map-o nav-icon" aria-hidden="true"></i>
												<p>Lista de clientes</p>
											</router-link>
										</li>
										<li class="nav-item">
											<router-link to="/deudas" class="nav-link">
												<i class="fa fa-address-card-o nav-icon" aria-hidden="true"></i>
												<p>Ventas</p>
											</router-link>
										</li>	
									</ul>
								</li>
								@break
							@default
								
						@endswitch

					</ul>
				</nav>
			</div>
		</aside>
    
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" style="min-height: 600px;">
    
			<!-- Main content -->
			<section class="content mt-4">
                @yield('content')
			</section>
		</div>
		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<b>Versión</b> 1.0
			</div>
						
			<strong>Copyright &copy; 2019, Soluciones Tecnológicas a Medida  <a href="http://www.google.com">Sistema de Prestamos</a>.</strong> Todos los derechos reservados.
		</footer>
    </div>
	
	<script src="{{ asset('js/app.js') }}"></script>
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