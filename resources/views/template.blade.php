<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="a CTF app">
	<meta name="authors"      content="...">
	<meta name="theme-color" content="#22272f">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="base" content="{{ URL::to('/') }}">

	<title>0x33 CTF - The best CTF maker</title>

    <link rel="shortcut icon" href= "{{ asset('images/gt_favicon.png') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	<script src="{{ asset('js/app.js') }}"></script>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- Load c3.css -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.15/c3.css" rel="stylesheet">

	<!-- Load d3.js and c3.js -->
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.15/c3.min.js"></script>
</head>

<body class="home">
	<header>
		<div class="navbar-fixed">
			<nav class="">
				<div class="container nav-wrapper">
					<a class="brand-logo" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}"></a>
					<a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="{{ url('/home') }}">Home</a></li>
						<li><a href="{{ url('/scoreboard') }}">Scoreboard</a></li>
						<li><a href="{{ url('/teams') }}">Teams</a></li>
						<li><a href="{{ url('/help') }}">Help</a></li>
						@if (Auth::user())
							<li>{!! link_to(route('logout'), 'Sign out', ['class' => 'btn btn-action']) !!}</li>
							<li><span>{{ Auth::user()->name }}</span></li><!-- TODO Logo du profile ?-->
						@else
							<li><a class="btn" href="{{ url('login') }}">SIGN IN/UP</a></li>
						@endif
					</ul>
				</div>
			</nav>
		</div>
	</header>
	<main>
		<ul class="sidenav" id="mobile">
			<li class="active"><a href="{{ url('/home') }}">Home</a></li>
			<li><a href="{{ url('/scoreboard') }}">Scoreboard</a></li>
			<li><a href="{{ url('/teams') }}">Teams</a></li>
			<li><a href="{{ url('/help') }}">Help</a></li>
			<li><a class="btn" href="{{ url('login') }}">SIGN IN/UP</a></li>
			@if (Auth::user())
				<li>{!! link_to(route('logout'), 'Sign out', ['class' => 'btn btn-action']) !!}</li>
				<li><span>{{ Auth::user()->name }}</span></li>
			@else
				<li><a class="btn" href="{{ url('login') }}">SIGN IN/UP</a></li>
			@endif
		</ul>

		@yield('contenu')
	</main>
	<footer class="page-footer" style="padding: 0">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="">Contact</h5>
					<a href="mailto:#">0x33ctf@univ-reims.fr</a>
				</div>

				<div class="col l6 s12">
					<h5 class="">Follow us</h5>
						<a href=""><i class="fab fa-twitter fa-2"></i></a>
						<a href=""><i class="fab fa-dribbble fa-2"></i></a>
						<a href=""><i class="fab fa-github fa-2"></i></a>
						<a href=""><i class="fab fa-facebook fa-2"></i></a>
				</div>
			</div>
		</div>
		<div class="footer-copyright" style="padding : 0">
            <div class="container" >
				Copyright &copy; 2020 Designed by Dylan & Vince.
			</div>
        </div>
	</footer>
</body>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		M.Sidenav.init(document.querySelectorAll('.sidenav'), null);
		M.Parallax.init( document.querySelectorAll('.parallax') , null);
	});
</script>
</html>
