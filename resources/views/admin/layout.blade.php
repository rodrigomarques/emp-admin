<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <title>Empório Naval</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin_color.css') }}">
</head>
<body class="hold-transition light-skin sidebar-mini theme-primary">

<div class="wrapper">
    <header class="main-header">
	<div class="box-logo" style="height: 70px!important;">
		<div class="d-flex align-items-center logo-box justify-content-between">
			<!-- logo-->
			<div class="logo-lg">
				<span class="light-logo"><img src="{{ asset('images/logo.png') }}" alt="logo" style="padding-top: 10px; width: 90%; padding-left: 18px;"></span>
			</div>
			</a>
		</div>
	</div>
<!-- Header Navbar -->
    <nav class="navbar navbar-static-top pl-10">
      <!-- Sidebar toggle button-->
	  <div class="app-menu">
		<ul class="header-megamenu nav">
			<li class="btn-group nav-item d-none d-xl-inline-block" style="padding-left: 20px;">
				Olá <strong>Nome Sobrenome</strong>
			</li>
		</ul>
	  </div>

      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
			<li class="btn-group d-lg-inline-flex d-none">
				<div class="app-menu">
					<div class="search-bx mx-5 d-none">
						<form>
							<div class="input-group">
							  <input type="search" class="form-control" placeholder="Busca" aria-label="Search" aria-describedby="button-addon2">
							  <div class="input-group-append">
								<button class="btn" type="submit" id="button-addon3"><i class="ti-search"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</li>
	      <!-- User Account-->
          <li class="dropdown user user-menu">
            <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="User">
				<i class="ti-user"></i>
            </a>
            <ul class="dropdown-menu animated flipInX">
              <li class="user-body">
				 <a class="dropdown-item" href="{{ route('sair') }}"><i class="ti-lock text-muted mr-2"></i> Sair</a>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>


  <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
	<div class="user-profile px-10 py-15">
			<div class="d-flex align-items-center">
							</div>
        </div>

        @if(auth()->user() && auth()->user()->isRoleAdmin())
		<!-- MENU DO NÍVEL ADMINISTRADOR -->
		<ul class="sidebar-menu" data-widget="tree">
					<li>
						<a href="{{ route('admin.home') }}">
						<i class="fa fa-dashboard" aria-hidden="true"></i>
							<span>Início</span>
						</a>
					</li>
					<li class="treeview menu-open">
						<a href="#">
							<i class="fa fa-users"></i>
							<span>Associados</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu" style="">
							<li><a href="{{ route('admin.associado.buscar') }}">Associados</a></li>
							<li><a href="{{ route('admin.associado.aguardando.aprovacao') }}">Aguardando Aprovação</a></li>
							<li><a href="{{ route('admin.associado.dependentes') }}">Dependentes</a></li>
						</ul>
					</li>
					<li class="treeview menu-open">
						<a href="#">
							<i class="fa fa-gift"></i>
							<span>Cupom de Desconto</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu" style="">
							<li><a href="{{ route('admin.cupom.index') }}">Adicionar Cupom</a></li>
							<li><a href="{{ route('admin.cupom.buscar') }}">Cupons Gerados</a></li>
						</ul>
					</li>
					<li>
						<a href="financeiro.php">
						<i class="fa fa-dollar" aria-hidden="true"></i>
							<span>Financeiro</span>
						</a>
					</li>
					<li>
						<a href="{{ route('sair') }}">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
							<span>Sair</span>
						</a>
					</li>
		</ul>
		<!-- FIM MENU NÍVEL ADMINISTRADOR -->
        @endif

		<!-- MENU DO NÍVEL ASSOCIADO -->
        @if(auth()->user() && auth()->user()->isRoleOnlyAssociado())
		<ul class="sidebar-menu" data-widget="tree">
					<li>
						<a href="perfil.php">
							<i class="fa fa-user" aria-hidden="true"></i>
							<span>MEUS DADOS</span>
						</a>
					</li>
					<li>
					<a href="meusDependentes.php">
						<i class="fa fa-users"></i>
						<span>DEPENDENTES</span>
					</a>
					<li>
						<a href="meuFinanceiro.php">
							<i class="fa fa-dollar" aria-hidden="true"></i>
							<span>MEUS PAGAMENTOS</span>
						</a>
					</li>
					</li>
					<li>
						<a href="{{ route('sair') }}">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
							<span>Sair</span>
						</a>
					</li>
		</ul>
        @endif
		<!-- FIM MENU NÍVEL ADMINISTRADOR -->

    </section>

  </aside>

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Main content -->
		<section class="content">
			<!-- AQUI ENTRA O CONTEÚDO DO DASHBOARD -->
			<div class="row">
                @if ($message = Session::get('success'))
                <div class="col-12">
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                </div>
                @endif

                @if($errors->any())
                    <div class="col-12">
                    <div class="mt-2 alert alert-warning">
                        <ul>
                            @foreach($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="col-12">
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                </div>
                @endif
                @yield("content")
            </div>
        </section>
      </div>
    </div>

    <div class="control-sidebar-bg"></div>

    <div class="modal fade modal-component" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel"><span id="modal-title-text"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="modal-body-content">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-left" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS -->
    <script src="{{ asset('js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/progressbar.js-master/dist/progressbar.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/perfect-scrollbar-master/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/jquery-steps-master/build/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/pages/steps.js') }}"></script>

    <script src="{{ asset('assets/vendor_components/chart.js-master/Chart.min.js') }}"></script>
	<script src="{{ asset('js/pages/widget-charts2.js') }}"></script>

    @yield('scriptjs')
</body>
</html>
