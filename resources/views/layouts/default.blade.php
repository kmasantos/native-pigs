<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize.min.css')}}"  media="screen,projection"/>
      {{-- <link type="text/css" rel="stylesheet" href="{{asset('thirdparty/materialize/css/font-awesome.css')}}"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize-social.css')}}"  media="screen,projection"/> --}}
      <script src="https://use.fontawesome.com/62579facae.js"></script>
      <link type="text/css" rel="stylesheet" href="{{asset('css/default.css')}}"  media="screen,projection"/>
      @yield('initScripts')
  <title>@yield('title')</title>
</head>
<body @yield('page-id') style="display: flex; min-height: 100vh; flex-direction: column;">
 <div class="navbar-fixed">
    <nav class="blue-grey">
      <div class="nav-wrapper" style="padding-left: 10px;">
        <a href="{{url('/')}}" class="brand-logo"><img src="{{asset('images/logo-default.png')}}" alt="Native Animals" height="65" / ></a>
      </div>
    </nav>
  </div>
  @yield('navigation')

  <div style="flex: 1 0 auto;">
    @yield('content')
  </div>



  <footer class="page-footer blue-grey">
    <div>
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
      <div>
        © 2017 Copyright Text
        <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
      </div>
    </div>
  </footer>
  <script type="text/javascript" src="{{asset('/thirdparty/jquery-3.2.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('/thirdparty/materialize/js/materialize.min.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('config.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom.js')}}"></script> --}}
  @yield('scripts')
</body>
</html>
