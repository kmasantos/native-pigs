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
                    <img src="{{asset('images/header2.jpg')}}">
                    <div class="caption right-align">
                        <h5>Boar Shed originally designed by MSC</h5>
                    </div>
                </li>
                <li>
                    <img src="{{asset('images/header3.jpg')}}">
                    <div class="caption right-align">
                        <h5 class="light grey-text text-lighten-3">Photo courtesy of BAI-NSPRDC</h5>
                    </div>
                </li>
                <li>
                    <img src="{{asset('images/header4.jpg')}}">
                </li>
                <li>
                    <img src="{{asset('images/header5.jpg')}}">
                    <div class="caption right-align">
                        <h5 class="light yellow-text">Photo courtesy of BAI-NSPRDC</h5>
                    </div>
                </li>
            </ul>
        </div>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div id="breeds" class="section scrollspy">
                        <h4 class="center">Philippine Native Pigs</h4>
                        <div class="row">
                            <p style="text-align: justify;">The Q-Black, MSC's breed, Sinirangan, ISUbela, and Benguet native pigs tend to have the same physical features. They all have the same straight hair type, plain black coat, and smooth skin. On the other hand, the Yookah native pigs have the unique pattern of black coat with "white socks" but similar straight hair and smooth skin.</p>
                            <p style="text-align: justify;">Among the six genetic groups, at 180 days of age, the smallest is Yookah with a weight of 15 kilograms, while the bigger ones are Q-Black and native pigs of MSC, with weights between 30-40 kilograms.</p>
                            <p><strong>Reproductive Performance</strong></p>
                            <p style="text-align: justify;">The MSC and ISUbela native pigs farrow seven (7) piglets per litter, while Yookah on average has four (4) piglets.</p>
                            <p style="text-align: justify;">In terms of birth weight, Q-Black is usually the heaviest at 0.84 kilogram on average, followed by ISUbela and Benguet at 0.77 kilogram.</p>
                            <p style="text-align: justify;">Q-Black and MSC native piglets are weaned at forty-two (42) to forty-five (45) days. Piglets of ISUbela were weaned as early as thirty-four (34) days with an average weight of 3.00 kilograms.</p>
                        </div>
                        <h5 class="center">Gilts at 6 months</h5>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/q-black_grid.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Q-Black<a href="{{url('/breed/q-black')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/BSU-grid.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Benguet<a href="{{url('/breed/benguet')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/sinirangan_grid.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Sinirangan<sup>&reg;</sup><a href="{{url('/breed/sinirangan')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/ISU-grid.JPG')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">ISUbela<a href="{{url('/breed/isubela')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/KSU-grid.JPG')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Yookah<a href="{{url('/breed/yookah')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/MSC-grid.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Native Pig of MSC<a href="{{url('/breed/marinduke')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="farms" class="section scrollspy">
                        <h4 class="center">Farms and Cooperators</h4>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h5>Benguet</h5>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">The Animal Genetic Resource Project - Benguet State University</li>
                                        <li class="collection-item grey lighten-1">Dr. Sonwright B. Maddul</li>
                                        <li class="collection-item grey lighten-1">0929 311 3996 / 0916 364 2039</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h5>Sinirangan<sup>&reg;</sup></h5>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">ESSU Sinirangan<sup>&reg;</sup> Pig Center - Eastern Samar State University Borongan Campus</li>
                                        <li class="collection-item grey lighten-1">Dr. Felix A. Afable / Dr. Sharon B. Singzon</li>
                                        <li class="collection-item grey lighten-1">essuphilnativepig@gmail.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h5>ISUbela</h5>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Isabela State University Echague Campus</li>
                                        <li class="collection-item grey lighten-1">Dr. Joel L. Reyes</li>
                                        <li class="collection-item grey lighten-1">0917 362 5996 / joellreyes@yahoo.com</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h5>Yookah</h5>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Kalinga State University Native Pig R&D Project</li>
                                        <li class="collection-item grey lighten-1">Sharmaine D. Codiam</li>
                                        <li class="collection-item grey lighten-1">0927 722 4283</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h5>Q-Black</h5>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Bureau of Animal Industry - National Swine and Poultry Research and Development Center</li>
                                        <li class="collection-item grey lighten-1">Rico M. Panaligan</li>
                                        <li class="collection-item grey lighten-1">(042) 585 7727 / 0997 693 2766</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Tiaong Native Pig Farm</li>
                                        <li class="collection-item grey lighten-1">Edwin Mendoza</li>
                                        <li class="collection-item grey lighten-1">0945 379 3173</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Kaharian Farm</li>
                                        <li class="collection-item grey lighten-1">Danilo Rubio</li>
                                        <li class="collection-item grey lighten-1">0918 830 0191</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Don Leon Nature Farm</li>
                                        <li class="collection-item grey lighten-1">Dr. Noel Gutierez</li>
                                        <li class="collection-item grey lighten-1">0917 597 7954</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Ammani Farm</li>
                                        <li class="collection-item grey lighten-1">Carmen Serano</li>
                                        <li class="collection-item grey lighten-1">0905 460 9724</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">KML (Kilusan ng Magbubukid ng Lagalag)</li>
                                        <li class="collection-item grey lighten-1">Joseph Bomediano</li>
                                        <li class="collection-item grey lighten-1">0910 572 4570</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h5>Native Pig of MSC</h5>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Marinduque State College Torrijos Campus</li>
                                        <li class="collection-item grey lighten-1">Randell R. Reginio</li>
                                        <li class="collection-item grey lighten-1">0999 924 5638 / randell_reginio@yahoo.com</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Barangay Tigwi</li>
                                        <li class="collection-item grey lighten-1">Rolando Postrado</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Barangay Marlangga</li>
                                        <li class="collection-item grey lighten-1">Roger Quinto</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Barangay Sibuyao</li>
                                        <li class="collection-item grey lighten-1">Bedencio Linga</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Barangay Sibuyao</li>
                                        <li class="collection-item grey lighten-1">Alicia Regalado</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Barangay Bangwayin</li>
                                        <li class="collection-item grey lighten-1">Leon Perin</li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey">Barangay Pakaskasan</li>
                                        <li class="collection-item grey lighten-1">Remegio Rioflorido</li>
                                    </ul>
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
                            <img src="{{asset('images/news-icon.png')}}" height="400">
                            <h5>Articles coming soon!</h5>
                        </div>
                    </div>
                    <div id="about" class="section scrollspy">
                        <h4 class="center">About Us</h4>
                        <p class="center"><strong>What do you need to know about the data available in the Philippine Native Pig Breed Information System?</strong></p>
                        <h5 style="text-decoration: underline;">The Project</h5>
                        <p style="text-align: justify;">The "Development of Philippine Native Pig Breed Information System" is a DOST-PCAARRD funded project of the Institute of Animal Science in cooperation with the Institute of Computer Science, University of the Philippines Los Ba&ntilde;os. The project aims to provide an accessible information source regarding selected Philippine Native Pig Breeds.</p>
                        <h5 style="text-decoration: underline;">The Goal</h5>
                        <p style="text-align: justify;">The information in the website is accessible to the public and is hoped to be able to provide support for policy makers, community development practitioners, researchers, livestock keepers, and entrepreneurs towards native pig breed management.</p>
                        <p style="text-align: justify;">On the other hand, there is a recording system feature of the website, which registered farmers can use.</p>
                        <h5 style="text-decoration: underline;">The Data</h5>
                        <p style="text-align: justify;">The data available in this website include the morphological and reproductive performance traits of each native pig genetic group based on the records of the current breeders.</p>
                        <p style="text-align: justify;">The following are the data collected:</p>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <ul class="collection with-header">
                                    <li class="collection-header"><h5>Qualitative Data</h5></li>
                                    <li class="collection-item">Hair type</li>
                                    <li class="collection-item">Coat color and pattern</li>
                                    <li class="collection-item">Shape of head</li>
                                    <li class="collection-item">Ear type</li>
                                    <li class="collection-item">Skin type</li>
                                    <li class="collection-item">Backline</li>
                                    <li class="collection-item">Tail type</li>
                                </ul>
                            </div>
                            <div class="col s6 m6 l6">
                                <ul class="collection with-header">
                                    <li class="collection-header"><h5>Quantitative Data</h5></li>
                                    <li class="collection-item">Body weight</li>
                                    <li class="collection-item">Head length</li>
                                    <li class="collection-item">Body length</li>
                                    <li class="collection-item">Pelvic width</li>
                                    <li class="collection-item">Total teat number</li>
                                    <li class="collection-header"><h6>Information at birth:</h6></li>
                                    <li class="collection-item">Birth weight</li>
                                    <li class="collection-item">Litter size</li>
                                    <li class="collection-item">Number of males born</li>
                                    <li class="collection-item">Number of females born</li>
                                    <li class="collection-item">Age at weaning</li>
                                    <li class="collection-item">Weaning weight</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row center">
            <p>Data included in this database were collected by the following:</p>
        </div>
        <div class="row center">
            <div class="col s2 m2 l2">
                <img src="{{asset('images/bai.png')}}" height="100">
                <p>Bureau of Animal Industry - National Swine and Poultry Research and Development Center (BAI-NSPRDC)</p>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/bsu.png')}}" height="100">
                <p>Benguet State University (BSU)</p>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/essu.png')}}" height="100">
                <p>Eastern Samar State University (ESSU)</p>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/isu.png')}}" height="100">
                <p>Isabela State University (ISU)</p>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/ksu.png')}}" height="100">
                <p>Kalinga State University (KSU)</p>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/msc.png')}}" height="100">
                <p>Marinduque State College (MSC)</p>
            </div>
        </div>

         <footer class="page-footer green lighten-1">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Philippine Native Pig Breed Information System</h5>
                        <p class="grey-text text-lighten-4" style="text-align: justify;">The "Development of Philippine Native Pig Breed Information System" is a DOST-PCAARRD funded project of the Institute of Animal Science in cooperation with the Institute of Computer Science, University of the Philippines Los Ba&ntilde;os. The project aims to provide an accessible information source regarding selected Philippine Native Pig Breeds.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <img src="{{asset('images/dost.png')}}" height="70">
                        <img src="{{asset('images/pcaarrd.png')}}" height="70">
                        <img src="{{asset('images/uplb.png')}}" height="70">
                        <img src="{{asset('images/ias.png')}}" height="80">
                        <img src="{{asset('images/ics.png')}}" height="70">
                        <img src="{{asset('images/logo-default.png')}}" height="70">
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2017 All Rights Reserved
                </div>
            </div>
        </footer>

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
