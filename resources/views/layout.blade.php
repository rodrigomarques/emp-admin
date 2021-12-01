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
    <style>
        .titulo h2{
            color: #666;
            text-transform: uppercase;
            font-size: 20px;
            margin-top: 30px;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #e9ecef!important;
            opacity: 1;
        }
    </style>
</head>
<body class="hold-transition theme-primary bg-img" style="background: #162647;">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">
			<div class="col-10 bg-white rounded30 shadow-lg">
				<div class="row justify-content-center no-gutters">
					<div class="col-12 text-center">
                        <div class="content-top-agile p-20 pb-0">
                            <img src="{{ asset('images/logo.png') }}" alt="logo" width="300px;">
                        </div>
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
                            <div class="col-md-12">
                                @yield('content')
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Vendor JS -->
	<script src="{{ asset('js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $("#categoria").change(function() {
               var categoria = $(this).val();

               if(categoria=='1'){
                $("#nip").removeAttr("disabled");
                $('#pagamentoNIP').show();
                $('#pagamento').hide();
               }else{
                $("#nip").attr("disabled",true);
                $('#pagamento').show();
                $('#pagamentoNIP').hide();
               }

            });
        });
    </script>

    <script>
          $(document).ready(function(){
          $('.date').mask('00/00/0000');
          $('.time').mask('00:00:00');
          $('.date_time').mask('00/00/0000 00:00:00');
          $('.cep').mask('00000-000');
          $('.phone').mask('0000-0000');
          $('.phone_with_ddd').mask('(00) 0000-0000');
          $('.phone_us').mask('(000) 000-0000');
          $('.mixed').mask('AAA 000-S0S');
          $('.cpf').mask('000.000.000-00', {reverse: true});
          $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
          $('.money').mask('000.000.000.000.000,00', {reverse: true});
          $('.money2').mask("#.##0,00", {reverse: true});
          $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            translation: {
              'Z': {
                pattern: /[0-9]/, optional: true
              }
            }
          });
          $('.ip_address').mask('099.099.099.099');
          $('.percent').mask('##0,00%', {reverse: true});
          $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
          $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
          $('.fallback').mask("00r00r0000", {
              translation: {
                'r': {
                  pattern: /[\/]/,
                  fallback: '/'
                },
                placeholder: "__/__/____"
              }
            });
          $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
    });
    </script>

    @yield('scriptjs')
</body>
</html>
