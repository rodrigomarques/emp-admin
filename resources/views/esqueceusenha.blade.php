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

<body class="hold-transition theme-primary bg-img" style="background: #162647;">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center no-gutters">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded30 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<img src="{{ asset('images/logo.png') }}" alt="logo" width="300px;">
							</div>
							<div class="content-top-agile pb-0">
							</div>
							<div class="p-40">
                                @if ($message = Session::get('success'))
                                <div class="col-12">
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ $message }}</strong>
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
								<form action="{{ route('send-esqueceu-senha') }}" method="post">
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											</div>
											<input type="text" name="email" class="form-control pl-15 bg-transparent" placeholder="Login">
										</div>
									</div>
									  <div class="row">
										<div class="col-6">
										 <div class="fog-pwd text-right">
											<a href="{{ route('login') }}" class="hover-warning"><i class="ion ion-locked"></i> Logar</a><br>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="submit" class="btn mt-10" style="background: #162647; color: #FFF;">Enviar Senha</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
