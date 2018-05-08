<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Native Ducks and Chicken | @yield('title')</title>
    <link rel="stylesheet" href="/thirdparty/fontawesome-free-5.0.4/web-fonts-with-css/css/fontawesome-all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/thirdparty/materialize/css/materialize.min.css">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/poultry/custom.css">
    @yield('initScriptsAndStyles')
  </head>
  <body>
    <ul id="slide-out" class="side-nav fixed yellow lighten-2">
      <li><div class="user-view">
        <div class="background ">
          <img src="http://via.placeholder.com/350x400">
        </div>
        <a href="#!"><img class="circle" src="/images/farmer.png"></a>
        <a href="#!name"><span class="black-text name">{{Auth::user()->name}}</span></a>
        <a href="#!email"><span class="black-text email">{{Auth::user()->email}}</span></a>
      </div></li>

      <li class="no-padding">
        <ul>
          <li>
            <a href="{{route('farm.poultry.dashboard')}}" class="collapsible-header">Dashboard<i class="material-icons">dashboard</i></a>
          </li>
        </ul>
      </li>

      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Breeder Record<i class="material-icons">add_circle</i></a>
            <div class="collapsible-body">
              <ul class="yellow lighten-3">
                <li><a href="{{route('farm.poultry.page_family_record')}}">Family Record</a></li>
                <li><a href="{{route('farm.poultry.page_add_to_breeder')}}">Add to Family</a></li>
                {{-- <li><a href="{{route('farm.poultry.page_phenotypic_characteristics')}}">Phenotypic Characteristics</a></li> --}}
                {{-- s<li><a href="{{route('farm.poultry.page_morphometric_characteristics')}}">Morphometric Characteristics</a></li> --}}
                <li><a href="{{route('farm.poultry.page_daily_records')}}">Daily Records</a></li>
                <li><a href="{{route('farm.poultry.page_hatchery_parameters')}}">Hatchery Parameters</a></li>
                <li><a href="{{route('farm.poultry.page_egg_quality')}}">Egg Quality Characteristics</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>

      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Replacement Stocks Record<i class="material-icons">add_circle_outline</i></a>
            <div class="collapsible-body">
              <ul class="yellow lighten-3">
                <li><a href="{{route('farm.poultry.page_replacement_individual_record')}}">Individual Record</a></li>
                <li><a href="{{route('farm.poultry.page_replacement_growth_performance')}}">Growth Performance</a></li>
                <li><a href="{{route('farm.poultry.page_phenomorphosearchid')}}">Phenotypic and Morphometric</a></li>
                {{-- <li><a href="{{route('farm.poultry.page_phenomorphosearchid')}}">Morphometric Characteristics</a></li> --}}
              </ul>
            </div>
          </li>
        </ul>
      </li>

      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Others<i class="material-icons">trending_up</i></a>
            <div class="collapsible-body">
              <ul class="yellow lighten-3">
                <li><a href="{{route('farm.poultry.page_feeding_records')}}">Feeding Records</a></li>
                <li><a href="{{route('farm.poultry.page_monthly_sales')}}">Monthly Sales</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>

      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Farm Settings<i class="material-icons">settings</i></a>
            <div class="collapsible-body">
              <ul class="yellow lighten-3">
                <li><a href="#!">Edit Farm Profile</a></li>
                <li><a href="#!">Logout</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>

    </ul>

    {{-- Remove comment for responsive app for mobile phones --}}
    {{-- <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a> --}}

    <header class="yellow lighten-3 nav-wrapper center">
      <div class="logo">
        <a href="{{route('farm.index')}}" class="brand-logo"><img src="/images/logo-poultry.png" height="70" / ></a>
      </div>
    </header>

    <main>
      <div class="container">
        @yield('content')
      </div>
    </main>

    <footer class="page-footer yellow lighten-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="black-text">Native Chicken and Ducks</h5>
                <p class="black-text">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="black-text">Links</h5>
                <ul>
                  <li><a class="black-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="black-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="black-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="black-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container black-text">
            © 2018 Copyright Text
            <a class="black-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
        </footer>


    <script type="text/javascript" src="/thirdparty/jquery-3.2.1.js"></script>
    <script type="text/javascript" src="/thirdparty/materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>
    @yield('scripts')
  </body>
</html>
