<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="pt-br">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Process Mapper | Admin</title>

	<link href="{{ asset("admin/css/bootstrap.min.css ") }}" rel="stylesheet">
	<link href="{{ asset("css/font-awesome.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/plugins/toastr/toastr.min.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/animate.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/style.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/TimeCircles.css") }}" rel="stylesheet">
	<link href="{{ asset("css/sweetalert2.min.css") }}" rel="stylesheet">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	@stack('stylesheets')

</head>

<body class="pace-done">
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
							<a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

			</div>

	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
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


	<!-- Latest compiled and minified JavaScript -->


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

	<script>


		$(document).ready(function() {

			var url = window.location;

			$('ul#side-menu a').filter(function() {
			 return this.href == url;
		 }).parent().addClass('active').attr('href', '#');

		});

	</script>

	@stack('scripts')

	<script>
		openSwalPageLoaded();
	</script>

</body>

</html>
