<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Meu Blog</title>

	<link
		rel="stylesheet"
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
		crossorigin="anonymous"
	>
</head>
<body>
	<header class="navbar navbar-dark bg-success">
		<div class="container">
			<a class="navbar-brand" href="{{ url('') }}">
				Meu Blog
			</a>

			@if(Auth::check())
			<div class="justify-content-end">
				<span class="my-navbar-item"> {{ Auth::user()->name }} さん</span>
				|
				<a href="#" id="logout" class="my-navbar-item">ログアウト</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				 @csrf
				</form>
			@else
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">ログイン</a>
                        |
						<a href="{{ route('register') }}">ユーザ登録</a>
                    @endauth
                </div>
			@endif
			|
			<a href="{{ url('about') }}">about</a>
			</div>
		</div>
	</header>
	
	<div>
		@yield('content')
	</div>
</body>
</html>

