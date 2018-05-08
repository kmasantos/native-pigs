<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="thirdparty/materialize/css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
      @yield('content')
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="thirdparty/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="thirdparty/materialize/js/materialize.min.js"></script>
      @yield('initscripts')
    </body>
  </html>
