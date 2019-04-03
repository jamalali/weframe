<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<script src="{{ asset('js/manifest.js') }}" defer></script>
		<script src="{{ asset('js/vendor.js') }}" defer></script>
		<script src="{{ asset('js/app.js') }}" defer></script>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<nav class="navbar is-primary">
				
				<div class="navbar-brand">
					<a class="navbar-item" href="{{ url('/') }}">
						<strong>
							{{ config('app.name', 'Laravel') }}
						</strong>
					</a>

					<a role="button" class="navbar-burger burger" data-target="navMenu">
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</a>
				</div>
				
				<div id="navMenu" class="navbar-menu">
					
					<div class="navbar-start">
						
					</div>

					<div class="navbar-end">
						@guest
							<a class="navbar-item" href="{{ route('login') }}">
								{{ __('Login') }}
							</a>
						
							@if (Route::has('register'))
								<a class="navbar-item" href="{{ route('register') }}">
									{{ __('Register') }}
								</a>
							@endif
						@else
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link is-arrowless" href="#">
									Me
								</a>

								<div class="navbar-dropdown is-right">
									<a class="navbar-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</div>
						@endguest
					</div>
					
				</div>
				
			</nav>

			<section class="section main">
				<div class="container is-fluid">
					@yield('content')
				</div>
			</section>
		</div>
	</body>
</html>