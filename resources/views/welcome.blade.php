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
                    <a href={{ url('/') }} class="brand-logo"><img src="{{asset('images/logo-swine.png')}}" alt="Native Pigs" height="65" / ></a>
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
                                      <span class="card-title activator grey-text text-darken-4">Q-Black<a href="{{url('/breed/q-black')}}"><i class="material-icons right">play_arrow</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/benguet.jpg')}}" height="290">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Benguet<a href="{{url('/breed/benguet')}}"><i class="material-icons right">play_arrow</i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/sinirangan.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Sinirangan<a href="{{url('/breed/sinirangan')}}"><i class="material-icons right">play_arrow</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/isubela.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">ISUbela<a href="{{url('/breed/isubela')}}"><i class="material-icons right">play_arrow</i></a></span>
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
                                      <span class="card-title activator grey-text text-darken-4">Yookah<a href="{{url('/breed/yookah')}}"><i class="material-icons right">play_arrow</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/marinduke.jpg')}}" height="290">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Native Pig of Marinduque<a href="{{url('/breed/marinduke')}}"><i class="material-icons right">play_arrow</i></a></span>
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
                                        <span class="card-title"><strong>BAI-NSPRDC</strong></span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Rico M. Panaligan</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>(042) 585-7727 / 0997 693 2766</td>
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
                                        <span class="card-title"><strong>Isabela State University</strong></span>
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
                                        <span class="card-title"><strong>Eastern Samar State University</strong></span>
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
                                        <span class="card-title"><strong>Benguet State University</strong></span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Dr. Sonwright B. Maddul</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>0929 316 3996 / 0916 364 2039</td>
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
                                        <span class="card-title"><strong>Kalinga State University</strong></span>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Contact Person</td>
                                                    <td>Sharmaine D. Codiam</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number</td>
                                                    <td>0927 722 4383</td>
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
                                        <span class="card-title"><strong>Marinduque State College</strong></span>
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
                        {{-- <ul class="collection">
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
                        </ul> --}}
                        <div class="center">
                            <img src="{{asset('images/news.gif')}}" height="40%">
                            <h5>Articles coming soon!</h5>
                        </div>
                    </div>
                    <div id="about" class="section scrollspy">
                        <h4 class="center">About Us</h4>
                        <p style="text-align: justify">The Philippine native pig is a source of food and additional livelihood in rural farming communities. Native pigs thrive in harsh environmental conditions with limited feeds and minimal management interventions resulting to lower production and maintenance costs than raising animals under an intensive production system. Albeit growing slowly and reaching market weight at a later time, the distinct taste and flavor of meat from native pigs are preferred especially for Philippine signature dishes such as "Lechon".</p>
                        <p style="text-align: justify">Sustainable management of these animal genetic resources can increase a farmer's income as well as lead to a stable supply of native pork quality products attuned to growing local demands. Characterization, monitoring, and inventory of native pig breeds are necessary for their sustainable management (FAO, 2015). In line with this, phenotypic characterization studies under the program BAI-DA are being conducted in key institutional farms.</p>
                        <p style="text-align: justify">The present project intends to complement and highlight these efforts through the development of a web-based information system which will focus on describing the predominant morphological characteristics distinct in each native pig breed and include information on their average performance to show their strength or advantage. Information accessible to a wide range of stakeholders including policy makers, community development practitioners, researchers, livestock keepers, and entrepreneurs can support decision-making processes regarding sustainable management and utilization of different native pig breeds. This information system may also serve as future platform for e-commerce and breed registry for native pigs which can be linked with other native animals as well.</p>
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
