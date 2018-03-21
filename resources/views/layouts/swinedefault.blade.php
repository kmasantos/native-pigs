<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
		<title>Native Pigs: @yield('title')</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="/thirdparty/materialize/css/materialize.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
		<link rel="stylesheet" href="/css/global.css">
		<link type="text/css" rel="stylesheet" href="{{asset('css/pig.css')}}"  media="screen,projection"/>
		@yield('initScriptsAndStyles')
	</head>
	<body>

		{{-- Fixed Side Navigation --}}
		<div class="navbar-fixed">
			<nav class="green lighten-1" role="navigation">
				<div class="nav-wrapper">
					<a href="{{route('farm.index')}}" class="brand-logo"><img src="/images/logo-swine.png" height="60" / ></a>
					<ul id="nav-mobile" class="right hide-on-med-and-down">
						<li><a href="{{route('farm.index')}}">Home</a></li>
						<li><a href="{{route('farm.index')}}">{{ Auth::user()->name }}</a></li>
						<li><a href="logout" id="logoutbutton" onclick="window.location='https://accounts.google.com/Logout?&continue=http://www.google.com/';">Logout</a></li>
					</ul>
				</div>
			</nav>
		</div>

		<ul id="slide-out" class="side-nav grey lighten-2 fixed">
			<li>
				<div class="user-view">
					<div class="background green lighten-1"></div>
					<a href="#!"><img class="circle" src="/images/farmer.png"></a>
					<a href="#!"><span class="white-text name">{{ Auth::user()->name }}</span></a>
					<a href="#!"><span class="white-text email">{{ Auth::user()->email   }}</span></a>
				</div>
			</li>
			<li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.index')}}" class="collapsible-header"><i class="material-icons">dashboard</i>Dashboard</a></a>
          </li>
        </ul>
      </li>
			<li><div class="divider green lighten-1"></div></li>
			<li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.individual_records')}}" class="collapsible-header"><i class="material-icons">info</i>Individual Records</a>
          </li>
        </ul>
      </li>
      <li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.breeding_record')}}" class="collapsible-header"><i class="material-icons">assignment</i>Breeding Record</a>
          </li>
        </ul>
      </li>
      <li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.mortality_and_sales')}}" class="collapsible-header"><i class="material-icons">remove_circle</i>Mortality and Sales</a>
          </li>
        </ul>
      </li>
			<li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header"><i class="material-icons">insert_chart</i>Reports</a>
            <div class="collapsible-body">
              <ul class="grey lighten-2">
                <li><a href="{{route('farm.pig.gross_morphology_report')}}">Gross Morphology</a></li>
                <li><a href="{{route('farm.pig.morpho_chars_report')}}">Morphometric Characteristics</a></li>
                <li><a href="{{route('farm.pig.breeder_production_report')}}">Breeder Production</a></li>
                <li><a href="{{route('farm.pig.production_performance_report')}}">Production Performance</a></li>
               	<li><a href="{{route('farm.pig.breeder_inventory_report')}}">Breeder Inventory</a></li>
               	<li><a href="{{route('farm.pig.grower_inventory_report')}}">Grower Inventory</a></li>
               	<li><a href="{{route('farm.pig.mortality_and_sales_report')}}">Mortality &amp; Sales</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
			<li><div class="divider green lighten-1"></div></li>
			<li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.farm_profile')}}" class="collapsible-header"><i class="material-icons">settings</i>Farm Profile</a>
          </li>
        </ul>
      </li>
		</ul>

		{{-- Extra components --}}
		@yield('extraComponents')

		{{-- Content of the page --}}
		<main>
			@yield('content')
		</main>

		{{-- Footer --}}

		<script type="text/javascript" src="/thirdparty/jquery-3.2.1.js"></script>
		<script type="text/javascript" src="/thirdparty/materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="/js/global.js"></script>
		<script type="text/javascript" src="{{asset('js/pig.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
		{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/js/materialize.min.js"></script> --}}

		@yield('scripts')
	</body>
</html>
