<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PAB-IS: Native Pigs</title>
        <link rel="shortcut icon" href="images/logo-swine-square.png" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize.min.css')}}"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
        {{-- <link rel="stylesheet" href="{{asset('css/global.css')}}"> --}}
        {{-- <link type="text/css" rel="stylesheet" href="{{asset('css/pig.css')}}"  media="screen,projection"/> --}}
    </head>
    <body>
        <div class="navbar-fixed">
            <nav class="green lighten-1" role="navigation">
                <div class="nav-wrapper">
                    <a href={{ url('/') }} class="brand-logo"><img src="{{asset('images/logo-swine.png')}}" alt="Native Animals" height="65" / ></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#breeds">Breeds</a></li>
                        <li><a href="#farms">Farms</a></li>
                        <li><a href="#news">News</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="{{url('login/google')}}">Login</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div id="home" class="slider scrollspy">
            <ul class="slides">
                <li>
                    <img src="{{asset('images/header1.JPG')}}">
                </li>
                <li>
                    <img src="{{asset('images/header1.JPG')}}">
                </li>
                <li>
                    <img src="{{asset('images/header1.JPG')}}">
                </li>
                <li>
                    <img src="{{asset('images/header1.JPG')}}">
                </li>
            </ul>
        </div>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div id="breeds" class="section scrollspy">
                        <h4 class="center">Breeds</h4>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/q-black.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Q-Black<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="card-reveal">
                                      <span class="card-title grey-text text-darken-4">Q-Black<i class="material-icons right">close</i></span>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Amet consectetur adipiscing elit ut aliquam purus sit. Mi in nulla posuere sollicitudin aliquam ultrices sagittis. Eget felis eget nunc lobortis mattis aliquam. Volutpat commodo sed egestas egestas fringilla. Ultricies integer quis auctor elit sed vulputate mi. Mauris ultrices eros in cursus turpis massa tincidunt dui ut. A arcu cursus vitae congue mauris rhoncus aenean. Id cursus metus aliquam eleifend mi.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/sinirangan.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Sinirangan<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="card-reveal">
                                      <span class="card-title grey-text text-darken-4">Sinirangan<i class="material-icons right">close</i></span>
                                      <p>Sit amet venenatis urna cursus eget nunc scelerisque viverra mauris. Malesuada proin libero nunc consequat interdum varius sit amet mattis. Et pharetra pharetra massa massa ultricies. Ultrices sagittis orci a scelerisque. Amet massa vitae tortor condimentum lacinia. Sit amet dictum sit amet justo donec. Non diam phasellus vestibulum lorem sed risus ultricies tristique. Eu non diam phasellus vestibulum lorem.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/benguet.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Benguet<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="card-reveal">
                                      <span class="card-title grey-text text-darken-4">Benguet<i class="material-icons right">close</i></span>
                                      <p>Et malesuada fames ac turpis egestas sed tempus. Mauris nunc congue nisi vitae suscipit tellus mauris. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit. Ridiculus mus mauris vitae ultricies leo integer malesuada. Tellus cras adipiscing enim eu turpis egestas. Vitae justo eget magna fermentum iaculis eu non. Tristique senectus et netus et malesuada fames ac turpis. Mauris ultrices eros in cursus turpis massa. Tortor vitae purus faucibus ornare suspendisse sed nisi lacus sed. Facilisis leo vel fringilla est ullamcorper eget. Curabitur vitae nunc sed velit.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/isubela.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">ISUbela<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="card-reveal">
                                      <span class="card-title grey-text text-darken-4">ISUbela<i class="material-icons right">close</i></span>
                                      <p>Arcu risus quis varius quam quisque id diam vel. Vel pharetra vel turpis nunc eget. Quis commodo odio aenean sed adipiscing diam donec adipiscing tristique. Risus at ultrices mi tempus imperdiet nulla. Lacus sed turpis tincidunt id aliquet risus. Parturient montes nascetur ridiculus mus mauris vitae ultricies leo integer. Elit eget gravida cum sociis natoque. Placerat in egestas erat imperdiet sed.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/yookah.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Yookah<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="card-reveal">
                                      <span class="card-title grey-text text-darken-4">Yookah<i class="material-icons right">close</i></span>
                                      <p>Bibendum neque egestas congue quisque egestas diam in arcu. Vivamus arcu felis bibendum ut tristique. Blandit turpis cursus in hac. Mauris commodo quis imperdiet massa. Ultrices mi tempus imperdiet nulla malesuada pellentesque elit eget. In nibh mauris cursus mattis molestie a iaculis at erat. Vel facilisis volutpat est velit egestas dui.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/marinduke.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Native Pig of Marinduque<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="card-reveal">
                                      <span class="card-title grey-text text-darken-4">Native Pig of Marinduque<i class="material-icons right">close</i></span>
                                      <p>Hendrerit dolor magna eget est lorem ipsum dolor sit amet. Faucibus in ornare quam viverra orci sagittis eu volutpat odio. Vitae suscipit tellus mauris a diam maecenas sed enim. Sem integer vitae justo eget magna fermentum iaculis. Ultricies mi quis hendrerit dolor magna eget est lorem ipsum. Fermentum et sollicitudin ac orci phasellus egestas tellus rutrum. Scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique senectus et. Sed sed risus pretium quam vulputate dignissim suspendisse in est.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="farms" class="section scrollspy">
                        <h4 class="center">Farms</h4>
                        <div class="row">
                            <div class="col s6">
                                <div class="card grey lighten-1">
                                    <div class="card-content">
                                        <span class="card-title">BAI-NSPRDC</span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Rico M. Panaligan</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>(042) 585-7727</td>
                                                </tr>
                                                <tr>
                                                    <td>Email address</td>
                                                    <td>bai_nsprdc@yahoo.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card grey lighten-1">
                                    <div class="card-content">
                                        <span class="card-title">Benguet State University</span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Dr. Franklin Balanban</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>0912 855 9997</td>
                                                </tr>
                                                <tr>
                                                    <td>Email address</td>
                                                    <td>balanban.franklin@gmail.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card grey lighten-1">
                                    <div class="card-content">
                                        <span class="card-title">Eastern Samar State University</span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Dr. Felix A. Afable</td>
                                                </tr>
                                                <tr>
                                                    <td>Email address</td>
                                                    <td>essuphilnativepig@gmail.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card grey lighten-1">
                                    <div class="card-content">
                                        <span class="card-title">Isabela State University</span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Dr. Joel L. Reyes</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>0917 362 5996</td>
                                                </tr>
                                                <tr>
                                                    <td>Email address</td>
                                                    <td>joellreyes@yahoo.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card grey lighten-1">
                                    <div class="card-content">
                                        <span class="card-title">Kalinga State University</span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Dr. Eduardo T. Bagtang</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>0917 568 0617</td>
                                                </tr>
                                                <tr>
                                                    <td>Email address</td>
                                                    <td>ksumail@gmail.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card grey lighten-1">
                                    <div class="card-content">
                                        <span class="card-title">Marinduque State College</span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Randell R. Reginio</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>0999 924 5638</td>
                                                </tr>
                                                <tr>
                                                    <td>Email address</td>
                                                    <td>randell_reginio@yahoo.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="news" class="section scrollspy">
                        <h4 class="center">News</h4>
                        <ul class="collection">
                            <li class="collection-item avatar">
                              <i class="material-icons circle blue">done</i>
                              <span class="title">Title</span>
                              <p>First Line <br>
                                 Second Line
                              </p>
                              <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                            <li class="collection-item avatar">
                              <i class="material-icons circle">folder</i>
                              <span class="title">Title</span>
                              <p>First Line <br>
                                 Second Line
                              </p>
                              <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                            <li class="collection-item avatar">
                              <i class="material-icons circle green">insert_chart</i>
                              <span class="title">Title</span>
                              <p>First Line <br>
                                 Second Line
                              </p>
                              <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                            <li class="collection-item avatar">
                              <i class="material-icons circle red">play_arrow</i>
                              <span class="title">Title</span>
                              <p>First Line <br>
                                 Second Line
                              </p>
                              <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                        </ul>
                    </div>
                    <div id="about" class="section scrollspy">
                        <h4 class="center">About Us</h4>
                        <p style="text-align: justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sagittis nisl rhoncus mattis rhoncus. Integer vitae justo eget magna fermentum iaculis eu. Egestas diam in arcu cursus euismod. Vehicula ipsum a arcu cursus vitae congue mauris rhoncus aenean. Dui accumsan sit amet nulla facilisi morbi tempus iaculis. Id volutpat lacus laoreet non curabitur gravida. Nec ullamcorper sit amet risus nullam. Nulla facilisi nullam vehicula ipsum a arcu cursus vitae. Aliquet nibh praesent tristique magna sit. Aliquam eleifend mi in nulla posuere sollicitudin aliquam ultrices. Amet consectetur adipiscing elit duis tristique sollicitudin nibh.</p>
                        <p style="text-align: justify">Blandit cursus risus at ultrices mi tempus imperdiet. Interdum velit laoreet id donec. Ultrices dui sapien eget mi proin sed libero enim sed. Id consectetur purus ut faucibus pulvinar elementum. Id porta nibh venenatis cras sed felis eget velit aliquet. Facilisis magna etiam tempor orci eu lobortis elementum. Morbi quis commodo odio aenean sed adipiscing diam donec adipiscing. Posuere morbi leo urna molestie at elementum eu. Integer feugiat scelerisque varius morbi enim nunc faucibus a pellentesque. Luctus accumsan tortor posuere ac ut consequat semper. Tortor dignissim convallis aenean et tortor at risus viverra. Mollis nunc sed id semper risus. Ut diam quam nulla porttitor massa. Pellentesque elit ullamcorper dignissim cras tincidunt lobortis feugiat vivamus at. Lobortis mattis aliquam faucibus purus in.</p>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{asset('thirdparty/jquery-3.2.1.js')}}"></script>
        <script type="text/javascript" src="{{asset('thirdparty/materialize/js/materialize.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.slider').slider({
                    height: 500
                });
            });
            $(document).ready(function(){
                $('.scrollspy').scrollSpy();
            });
        </script>
    </body>

</html>
