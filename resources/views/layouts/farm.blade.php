<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">
	    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	    <link type="text/css" rel="stylesheet" href="{{asset('materialize/css/materialize.css')}}"  media="screen,projection"/>
	    <link type="text/css" rel="stylesheet" href="{{asset('materialize/css/materialize-social.css')}}"  media="screen,projection"/>
	    <link type="text/css" rel="stylesheet" href="{{asset('materialize/css/font-awesome.css')}}"  media="screen,projection"/>
	   	<script src="https://use.fontawesome.com/62579facae.js"></script>
	    <link type="text/css" rel="stylesheet" href="{{asset('css/custom.css')}}"  media="screen,projection"/>
	    <link type="text/css" rel="stylesheet" href="{{asset('css/farm.css')}}"  media="screen,projection"/>
	    @yield('initScripts')
	<title>@yield('title')</title>
</head>
<body @yield('page-id')>
	<div class="navbar-fixed">
      <nav class="blue-grey">
      	<div id="slide-out" class="side-nav blue-grey fixed">
          <img src="{{asset('images/farmicon.png')}}" height="80" style="float:left;"/>
          <h3 class="center">{{ Auth::user()->name }}</h3>
          <div class="collection">
            <a href="{{url('/home')}}" class="white-text indent">Home</a>
            <ul class="collapsible blue-grey" data-collapsible="expandable">
              <li>
                <div class="collapsible-header active">Dashboard</div>
                <div class="collapsible-body green lighten-1">
                  <div class="collection blue-grey" style="text-align:right;">
					<a href="{{ route('farm.details') }}" class="white-text">Farm Details</a>
                    <a href="{{ route('farm.duckdetails') }}" class="white-text">Individual Records</a>
                    <a href="{{ route('farm.duckfamilydetails') }}" class="white-text">Family Records</a>	
                    <a href="{{ route('farm.pigrecords') }}" class="white-text">Records</a>
                    <a href="#!" class="white-text">Open Reports</a>
                  </div>
                </div>
              </li>
            </ul>
            <a href="{{ url('logout') }}" class="white-text indent">Logout</a>
          </div>
        </div>
        <div class="nav-wrapper container">
          <a href="{{ url('/') }}" class="brand-logo"><img src="{{asset('images/logo1.png')}}" height="65" /></a>
          <a href="{{ url('/') }}" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            @if (Auth::check())
				<li><a href="{{url('/home')}}">{{ Auth::user()->name }}</a> </li>
	            <li><a href="{{ url('/home') }}">Home</a></li>
	            <li><a href="{{ url('logout') }}">Logout</a></li>     	
	        @else
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
            @endif
          </ul> 
        </div>
      </nav>
    </div>

	@yield('navigation')
	<main>
		<div class="container">
			<div class="col">
				<div class="row">
					@yield('content')
				</div>
			</div>
		</div>
	</main>
	
	
	<footer class="page-footer blue-grey">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">Footer Content</h5>
					<p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
				</div>
				<div class="col l4 offset-l2 s12">
					<h5 class="white-text">Links</h5>
					<ul>
						<li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				© 2017 Copyright Text
				<a class="grey-text text-lighten-4 right" href="#!">More Links</a>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src="{{asset('js/jquery-3.2.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('materialize/js/materialize.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('config.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
	@yield('scripts')
</body>
</html>