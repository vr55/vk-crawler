<!DOCTYPE html>
<html lang="ru" class="">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>@yield('title')</title>

	<script type="text/javascript" src="//yastatic.net/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="//yastatic.net/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
	<link href="//yastatic.net/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">


	<link href="{{ asset('css/view.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/menu.css') }}" rel="stylesheet" type="text/css">
</head>

<body>

@include('layouts.nav')
<div id="wrap">
	<div class="container">

	<div class="row">
		<div class="col-md-3">
			@yield('aside')
			@include( 'left_menu' )
		</div>
		<div class="col-md-9">
		<div class="row">
			@if ( session()->has('msg') )
				<div class="alert alert-danger" role="alert">
					{{ session('msg') }}
				</div>
			@endif
			@if ( count( $errors ) > 0 )
				<div class="alert alert-danger">
					<ul>
						@foreach ( $errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		@yield('content')
		</div>
		</div>
	</div>

	</div>
</div>
<footer role="contentinfo" class="site-footer" id="colophon">
  <div class="copyright">
    <div class="container">
      <div class="row copyright-img">
        <div class="col-lg-4 col-sm-4">
			<a href="http://www.monochromatic.ru"><img src="http://www.monochromatic.ru/mc_logo32.png" alt="monochromatic logo" /></a> Copyright © 2016-{{date('Y')}} by <a href="http://www.monochromatic.ru">Monochromatic</a>
		</div>
      </div>
    </div>
  </div>
</footer>

</body>

</html>
