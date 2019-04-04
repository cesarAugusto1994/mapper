<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="pt-br">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>{{ config('app.name') }} @section('title')</title>

	<link href="{{ asset("admin/css/bootstrap.min.css ") }}" rel="stylesheet">
	<link href="{{ asset("css/font-awesome.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/animate.css ") }}" rel="stylesheet">
	<link href="{{ asset("admin/css/style.css ") }}" rel="stylesheet">
	@stack('stylesheets')

</head>

<body class="gray-bg">

	@yield('content')


	<!--<script src="{{asset('admin/js/jquery-2.1.1.js')}}"></script>-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('admin/js/inspinia.js')}}"></script>
	<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
	@stack('scripts')

</body>

</html>
