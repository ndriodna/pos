<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transistion login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="{{url('/')}}"><b>Admin</b></a>
		</div>
		@yield('content')
	</div>
	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
	<script>
	$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass   : 'iradio_square-blue',
				increaseArea : '20%' // optional
			})
	});
	</script>
</body>
</html>