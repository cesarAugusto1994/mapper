<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="pt-br">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>

	<link href="{{ asset("admin/css/bootstrap.min.css ") }}" rel="stylesheet">
	<link href="{{ asset("css/font-awesome.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/plugins/toastr/toastr.min.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/animate.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/style.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/TimeCircles.css") }}" rel="stylesheet">
	<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css" rel="stylesheet"/>

	<!--
	<link href="{{ asset("css/sweetalert2.min.css") }}" rel="stylesheet">
	-->



	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet">


	@stack('stylesheets')

</head>

<body class="pace-done skin-3">
	<div id="wrapper">

		@include('layouts.sidebar')

		<div id="page-wrapper" class="gray-bg dashbard-1">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
							<i class="fa fa-bars"></i>
						</a>
						<!--<form role="search" class="navbar-form-custom" method="get" action="#">
							<div class="form-group">
								<input type="text" placeholder="Pesquise por algo..." class="form-control" name="top-search" id="top-search">
							</div>
						</form>-->
					</div>
					<ul class="nav navbar-top-links navbar-right pull-right">
						<!--
						<li class="dropdown">
							<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
								<i class="fa fa-bell"></i>
								<span class="label label-primary">8</span>
							</a>
							<ul class="dropdown-menu dropdown-alerts">
								<li>
									<a href="mailbox.html">
										<div>
											<i class="fa fa-envelope fa-fw"></i> You have 16 messages
											<span class="pull-right text-muted small">4 minutes ago</span>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="profile.html">
										<div>
											<i class="fa fa-twitter fa-fw"></i> 3 New Followers
											<span class="pull-right text-muted small">12 minutes ago</span>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="grid_options.html">
										<div>
											<i class="fa fa-upload fa-fw"></i> Server Rebooted
											<span class="pull-right text-muted small">4 minutes ago</span>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<div class="text-center link-block">
										<a href="notifications.html">
											<strong>See All Alerts</strong>
											<i class="fa fa-angle-right"></i>
										</a>
									</div>
								</li>
							</ul>
						</li>
					-->
						<li>
							<a class="btnLogout">
								<div>
									<i class="fa fa-sign-out"></i> Sair
								</div>
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
						</li>

					</ul>
				</nav>
			</div>

			@yield('content')

			<div class="modal inmodal" id="editar-senha-home" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content animated bounceInRight">
									<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<img alt="image" style="max-width:64px;max-height:64px" class="img-circle" src="{{Gravatar::get(\Auth::user()->email)}}" />
											<br/>
											<h4 class="modal-title">Alterar Senha</h4>
									</div>
									<form action="{{route('user_update_password_home', ['id' => \Auth::user()->id])}}" method="post">
											{{csrf_field()}}
											<div class="modal-body">
													<div class="form-group"><label>Nova Senha</label>
														<input type="password" required autofocus name="password" placeholder="Informe a sua nova senha" autocomplete="off" class="form-control">

													</div>
											</div>
											<div class="modal-footer">
													<button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
													<button type="submit" class="btn btn-primary">Salvar</button>
											</div>
									</form>
							</div>
					</div>
			</div>

			</div>

	</div>

	@include('admin.modals.schedule')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.20.6/sweetalert2.all.min.js"></script>
	<script src="{{asset('admin/js/inspinia.js')}}"></script>
	<script src="{{asset('admin/js/funcoes.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.4/metisMenu.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/peity/3.3.0/jquery.peity.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="{{asset('admin/js/TimeCircles.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touch/1.1.0/jquery.touch.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
	<script>
    $('#flash-overlay-modal').modal();
		$('[data-toggle="tooltip"]').tooltip();
	</script>

	<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCdFj8jkxW4lzvZjL7R86Smrgy9lmO5wAE&libraries=places&dummy=.js"></script>

	<!-- Latest compiled and minified JavaScript -->





	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/pt-br.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/locale/pt-br.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>


	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

	<script>
      $('.summernote').summernote({
        placeholder: '',
        height: 250
      });
    </script>

<!--
	<script src="{{asset('admin/js/plugins/flot/jquery.flot.js')}}"></script>
	<script src="{{asset('admin/js/plugins/flot/jquery.flot.tooltip.min.j')}}s"></script>
	<script src="{{asset('admin/js/plugins/flot/jquery.flot.spline.js')}}"></script>
	<script src="{{asset('admin/js/plugins/flot/jquery.flot.resize.js')}}"></script>
	<script src="{{asset('admin/js/plugins/flot/jquery.flot.pie.js')}}"></script>
	<script src="{{asset('admin/js/plugins/flot/jquery.flot.time.js')}}"></script>
-->

	<!--
	<script src="{{asset('admin/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
	<script src="{{asset('admin/js/plugins/chartJs/Chart.min.js')}}"></script>
-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

	<script>

		$(document).ready(function() {

			var url = window.location;

			$('ul#side-menu a').filter(function() {
			 return this.href == url;
		 }).parent().addClass('active').attr('href', '#');

		});

		$('.inputDate').mask('00/00/0000');
	  $('.inputCep').mask('00000-000');
		$('.inputPhone').mask('(00)00000-0000');
	  $('.inputCpf').mask('000.000.000-00', {reverse: true});
		$('.inputMoney').mask('000.000.000.000.000,00', {reverse: true});

		$('.inputDate').datepicker({
	    format: "dd/mm/yyyy",
	    todayBtn: "linked",
	    clearBtn: true,
	    language: "pt-BR",
	    daysOfWeekDisabled: "0,6",
	    calendarWeeks: true,
	    autoclose: true,
	    todayHighlight: true,
	    toggleActive: true
		});

	</script>

	@stack('scripts')

	<script>
		//openSwalPageLoaded();
	</script>

	@if(\Auth::user()->change_password)
		<script>
				$(function() {
					$("#editar-senha-home").modal('show');
				});
		</script>
	@endif

	@if (notify()->ready())
    <script>
        swal({
            title: "{!! notify()->message() !!}",
            text: "{!! notify()->option('text') !!}",
            type: "{{ notify()->type() }}",
            @if (notify()->option('timer'))
                timer: {{ notify()->option('timer') }},
                showConfirmButton: false
            @endif
        });
    </script>
@endif

	<script>

	$(".inputCep").blur(function() {

			let route = $(this).data('cep');
			let value = $(this).val();

				$.ajax({
					type: 'GET',
					async: true,
					url: route+'?search='+value,
					success: function(response) {

							if(!response.success) {

								Swal.fire({
									type: 'error',
									title: 'Oops...',
									text: response.message,
								})

							}

							let dataResponse = response.data['response'];
							let dataResponseCoodenadas = response.data['coordenadas'];

							$("#street").val(dataResponse.logradouro);
							$("#district").val(dataResponse.bairro);
							$("#city").val(dataResponse.localidade);
							$("#state").val(dataResponse.uf);

							$("#long").val(dataResponseCoodenadas.lng);
							$("#lat").val(dataResponseCoodenadas.lat);
					}
				})

			//}



		});

		$(".btnRemoveItem").click(function(e) {
				var self = $(this);

				swal({
					title: 'Remover este item?',
					text: "Não será possível recuperá-lo!",
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Sim',
					cancelButtonText: 'Cancelar'
					}).then((result) => {
					if (result.value) {

						e.preventDefault();

						$.ajax({
							headers: {
							 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							 },
							url: self.data('route'),
							type: 'POST',
							dataType: 'json',
							data: {
								_method: 'DELETE'
							}
						}).done(function(data) {

							if(data.success) {

								self.parents('tr').hide();

								Swal.fire({
								  type: 'success',
								  title: 'Feito!',
								  text: data.message,
								})

							} else {

								Swal.fire({
								  type: 'error',
								  title: 'Oops...',
								  text: data.message,
								})

							}

						});
					}
				});
		});

		$('.btnLogout').click(function() {

		    swal({
		      title: 'Finalizar Sessão?',
		      text: "Esta sessão será finalizada!",
		      type: 'warning',
		      showCancelButton: true,
		      confirmButtonColor: '#3085d6',
		      cancelButtonColor: '#d33',
		      confirmButtonText: 'Sim',
		      cancelButtonText: 'Cancelar'
		      }).then((result) => {
		      if (result.value) {

		        document.getElementById('logout-form').submit();

		        swal({
		          title: 'Até logo!',
		          text: 'Sua sessão será finalizada.',
		          type: 'success',
		          showConfirmButton: false,
		        })
		      }
		    });

		  });

			$(".btnRedirectSoc").click(function() {

					var loginSoc = $("#usu").val();
					var passwordSoc = $("#senha").val();
					var idSoc = $("#empsoc").val();

					if(usu && loginSoc && loginSoc) {
							$("#formularioLoginSoc").submit();
					} else {

						Swal.fire({
							type: 'error',
							title: 'Falha ao logar no SOC',
							text: 'Informe as suas credenciais SOC no seu perfil',
						})

					}


			});

	</script>

</body>

</html>
