<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Native Pigs: @yield('title')</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize.min.css')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
		<link rel="stylesheet" href="{{asset('css/global.css')}}">
		<link type="text/css" rel="stylesheet" href="{{asset('css/pig.css')}}"  media="screen,projection"/>
		@yield('initScriptsAndStyles')
	</head>
	<body>

		{{-- Fixed Side Navigation --}}
		<div class="navbar-fixed">
			<nav class="green lighten-1" role="navigation">
				<div class="nav-wrapper">
					<a href="{{route('farm.index')}}" class="brand-logo"><img src="{{asset('images/logo-default.png')}}" alt="Native Animals" height="65" / ></a>
					<ul id="nav-mobile" class="right hide-on-med-and-down">
						<li><a href="{{route('farm.index')}}">{{ Auth::user()->name }}</a></li>
						<li><a href="logout" id="logoutbutton" onclick="window.location='https://accounts.google.com/Logout?&continue=http://www.google.com/';">Logout</a></li>
					</ul>
          <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
				</div>
			</nav>
		</div>

		<ul id="slide-out" class="sidenav grey lighten-2 sidenav-fixed">
			<li>
				<div class="user-view">
					<div class="background green lighten-1"></div>
					<a href="#!"><img class="circle" src="{{asset('images/farmer.png')}}" alt="Farm User"></a>
					<a href="#!"><span class="black-text name">{{ Auth::user()->name }}</span></a>
					<a href="#!"><span class="black-text email">{{ Auth::user()->email }}</span></a>
				</div>
			</li>
			<li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.index')}}" class="collapsible-header"><i class="material-icons">dashboard</i>Dashboard</a>
          </li>
        </ul>
      </li>
			<li><div class="divider green lighten-1"></div></li>
      <li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.add_pig')}}" class="collapsible-header"><i class="material-icons">add_box</i>Add New Pig</a>
          </li>
        </ul>
      </li>
			<li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.breeder_records')}}" class="collapsible-header"><i class="material-icons">folder_special</i>Breeder Records</a>
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
            <a href="{{route('farm.pig.grower_records')}}" class="collapsible-header"><i class="material-icons">create_new_folder</i>Grower Records</a>
          </li>
        </ul>
      </li>
      <li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.mortality_and_sales')}}" class="collapsible-header"><i class="material-icons">remove_from_queue</i>Mortality and Sales</a>
          </li>
        </ul>
      </li>
      <li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.pig.pedigree')}}" class="collapsible-header"><i class="material-icons">device_hub</i>Pedigree Viewer</a>
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
                <li><a href="{{route('farm.pig.growth_performance_report')}}">Growth Performance</a></li>
                <li><a href="{{route('farm.pig.production_performance_report')}}">Production Performance</a></li>
                <li><a href="{{route('farm.pig.monthly_performance_report')}}">Monthly Performance</a></li>
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
            <a href="{{route('farm.pig.farm_profile')}}" class="collapsible-header"><i class="material-icons">contact_mail</i>Farm Profile</a>
          </li>
        </ul>
      </li>
      <li class="no-padding">
      	<ul>
      		<li>
      			<a href="logout" id="logoutbutton" onclick="window.location='https://accounts.google.com/Logout?&continue=http://www.google.com/';" class="collapsible-header"><i class="material-icons">exit_to_app</i>Logout</a>
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
		<script type="text/javascript" src="{{asset('thirdparty/jquery-3.2.1.js')}}"></script>
		<script type="text/javascript" src="{{asset('thirdparty/materialize/js/materialize.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    @yield('scripts')
		<script type="text/javascript" src="{{asset('js/global.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/pig.js')}}"></script>
		{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/js/materialize.min.js"></script> --}}
	</body>
</html>
