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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/8958a6d4d1.js"></script>
        <style>
            .facebook {
                background-color: #3C5A99 !important;
            }

            nav#govph {
                height: 80px;
            }

            nav#nativepigs {
                height: 160px;
            }

            #gicon {
                margin-top: -5px;
            }

            nav#govph .nav-wrapper {
                height: 110px;
                padding-top: 5px;
                width: 70%;
                margin: 0 auto;
            }

            nav#nativepigs .nav-wrapper {
                height: 160px;
                padding-top: 5px;
                width: 70%;
                margin: 0 auto;
            }

            #home {
                width: 70%;
                margin: 0 auto;
            }
            

        </style>
        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize.min.css')}}"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
        {{-- <link rel="stylesheet" href="{{asset('css/global.css')}}"> --}}
        {{-- <link type="text/css" rel="stylesheet" href="{{asset('css/pig.css')}}"  media="screen,projection"/> --}}
    </head>
    <body>
        <div class="navbar">
            <nav id="govph" class="grey darken-3" role="navigation">
                <div class="nav-wrapper">
                    <ul class="hide-on-med-and-down">
                        <li><a href="https://www.gov.ph">GOVPH</a></li>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#breeds">Breeds</a></li>
                        <li><a href="#farms">Farms</a></li>
                        <li><a href="#news">News</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="../?privacy" target="_blank">Privacy Policy</a></li>
                        <li><a href="http://www.pcaarrd.dost.gov.ph/home/portal/index.php/philippine-transparency-seal/" target="_blank">Transparency Seal</a></li>
                        <li><a href="{{url('login/google')}}">Log In</a></li>
                    </ul>
                </div>
            </nav>
            <nav id="nativepigs" style="background:#6d929b;">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12 m10">
                            <a href="{{ url('/') }}" class="brand-logo"><img id="nav-logo-image"
                                src="{{asset('images/pcaarrd-header.png')}}" alt="DOST-PCAARRD" height="85" style="margin-top:10px;" /></a>
                                <br />
                                <h1 style="font-size:2em;text-align:left;margin-left:90px;text-transform:uppercase;letter-spacing:-0.05em">Philippine Native Pig Breed Information System</h1>    
                        </div>
                        <div class="col s12 m2">
                            <a href="http://www.pcaarrd.dost.gov.ph/home/portal/index.php/philippine-transparency-seal/" target="_blank"><img src="{{asset('images/transparency-seal.png')}}" width="100%" /></a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="grey darken-3">
            <div id="home" class="slider scrollspy">
                <ul class="slides">
                    <li>
                        <img src="{{asset('images/header1.jpeg')}}">
                    </li>
                    <li>
                        <img src="{{asset('images/header2.jpg')}}">
                        <div class="caption right-align">
                            <h3>Boar Shed originally designed by MSC</h3>
                        </div>
                    </li>
                    <li>
                        <img src="{{asset('images/header3.jpg')}}">
                        <div class="caption right-align">
                            <h3 class="light grey-text text-lighten-3">Photo courtesy of BAI-NSPRDC</h3>
                        </div>
                    </li>
                    <li>
                        <img src="{{asset('images/header4.jpg')}}">
                    </li>
                    <li>
                        <img src="{{asset('images/header5.jpg')}}">
                        <div class="caption right-align">
                            <h3 class="light yellow-text">Photo courtesy of BAI-NSPRDC</h3>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div id="breeds" class="section scrollspy">
                        <h3 class="center">Philippine Native Pigs</h3>
                        <div class="row">
                            <h5 style="text-align: justify;">The Q-Black, Markaduke, Sinirangan<sup>&reg;</sup>, ISUbela, and Benguet native pigs tend to have the same physical features. They all have the same straight hair type, plain black coat, and smooth skin. On the other hand, the Yookah<sup>&reg;</sup> native pigs have the unique pattern of black coat with "white socks" but similar straight hair and smooth skin.</h5>
                            <h5 style="text-align: justify;">Among the six genetic groups, at 180 days of age, the smallest is Yookah<sup>&reg;</sup> with a weight of 15 kilograms, while the bigger ones are Q-Black and Markaduke, with weights between 30-40 kilograms.</h5>
                            <h5 style="text-align: justify;">The Markaduke and ISUbela native pigs farrow seven (7) piglets per litter, while Yookah<sup>&reg;</sup> on average has four (4) piglets.</h5>
                            <h5 style="text-align: justify;">In terms of birth weight, Q-Black is usually the heaviest at 0.84 kilogram on average, followed by ISUbela and Benguet at 0.77 kilogram.</h5>
                            <h5 style="text-align: justify;">Q-Black and Markaduke are weaned at forty-two (42) to forty-five (45) days. Piglets of ISUbela are weaned as early as thirty-four (34) days with an average weight of 3.00 kilograms.</h5>
                        </div>
                        <h4 class="center">Gilts at 6 months</h4>
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
                                      <span class="card-title activator grey-text text-darken-4">Benguet Native Pig<a href="{{url('/breed/benguet')}}"><i class="material-icons right">launch</i></a></span>
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
                                      <img class="activator" src="{{asset('images/ISU-grid.jpeg')}}">
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
                                      <img class="activator" src="{{asset('images/KSU-grid.jpeg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Yookah<sup>&reg;</sup><a href="{{url('/breed/yookah')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                      <img class="activator" src="{{asset('images/MSC-grid.jpg')}}">
                                    </div>
                                    <div class="card-content">
                                      <span class="card-title activator grey-text text-darken-4">Markaduke<a href="{{url('/breed/marinduke')}}"><i class="material-icons right">launch</i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="farms" class="section scrollspy">
                        <h3 class="center">Farms and Cooperators</h3>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h4>Benguet Native Pig</h4>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>The Animal Genetic Resource Project - Benguet State University</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Dr. Sonwright B. Maddul</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0929 311 3996 / 0916 364 2039</h5></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h4>Sinirangan<sup>&reg;</sup></h4>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>ESSU Sinirangan<sup>&reg;</sup> Native Pig Center - Eastern Samar State University Borongan Campus</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Dr. Felix A. Afable / Dr. Sharon B. Singzon</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>essuphilnativepig@gmail.com</h5></li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Adriana Nature Farm, Brgy. Libuton, Borongan City</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Butch Afable</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0919 739 4910</h5></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h4>ISUbela</h4>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Isabela State University Echague Campus</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Dr. Joel L. Reyes</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0917 362 5996 / joellreyes@yahoo.com</h5></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h4>Yookah<sup>&reg;</sup></h4>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Kalinga State University Native Pig R&D Project</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Sharmaine D. Codiam</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0927 722 4283</h5></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h4>Q-Black</h4>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Bureau of Animal Industry - National Swine and Poultry Research and Development Center</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Rico M. Panaligan</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>(042) 585 7727 / 0997 693 2766</h5></li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Tiaong Native Pig Farm</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Edwin Mendoza</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0945 379 3173</h5></li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Kahariam Farm</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Danilo Rubio</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0918 830 0191</h5></li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Don Leon Nature Farm</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Dr. Noel Gutierez</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0917 597 7954</h5></li>
                                    </ul>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Ammani Farm</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Carmen Serano</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0905 460 9724</h5></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card-panel grey lighten-1">
                                    <h4>Markaduke</h4>
                                    <ul class="collection with-header">
                                        <li class="collection-header grey"><h5>Marinduque State College Torrijos Campus</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>Dr. Randell R. Reginio</h5></li>
                                        <li class="collection-item grey lighten-1"><h5>0999 924 5638 / randell_reginio@yahoo.com</h5></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="news" class="section scrollspy">
                        <h3 class="center">News and Events</h3>
                        <div class="row">
                            <div class="col s6 m6 l6">
                              <div class="card">
                                <div class="card-image">
                                    <img src="{{asset('images/news1-4.png')}}">
                                    <span class="card-title">News</span>
                                </div>
                                <div class="card-content">
                                    <h5>Increasing Demand of Marinduque Native Pigs, An appeal to the Nucleus Farm to prepare for Possible Shortage of Supply this Year</h5>
                                    <p><i>by Thon Roma (18 February, 2019)</i></p>
                                </div>
                                <div class="card-action">
                                    <a class="green-text text-lighten-1" href="{{url('/news/increasing_demand_of_marinduque_native_pigs')}}">Read more..</a>
                                </div>
                              </div>
                            </div>
                            <div class="col s6 m6 l6">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                        <img class="activator" src="{{asset('images/event1-1.jpeg')}}">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title activator" style="color: #F6008A;"><h5>Yookah (Native Pig) Fiesta<i class="material-icons right grey-text text-darken-4">more_vert</i></h5></span>
                                        <br>
                                        <h6>For more information:</h6>
                                        <a href="https://www.facebook.com/Kalinga-State-University-Yookah-Fiesta-431988890688960" class="btn facebook"><i class="fa fa-facebook-square left" aria-hidden="true"></i>Visit event page</a>
                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title" style="color: #F6008A;"><h4>Yookah (Native Pig) Fiesta<i class="material-icons right grey-text text-darken-4">close</i></h4></span>
                                        <h5><strong>Theme:</strong> "Black Pigs Living Astray&mdash;The Kalinga Way"</p>
                                        <h5><strong>When:</strong> June 27-28, 2019</h5>
                                        <h5><strong>Where:</strong> Kalinga State University Bulanao Campus, Tabuk City, Kalinga</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="center">
                            <img src="{{asset('images/news-icon.png')}}" height="400">
                            <h4>Articles coming soon!</h4>
                        </div> --}}
                    </div>
                    <div id="about" class="section scrollspy">
                        <h3 class="center">About Us</h3>
                        <h5 class="center"><strong>What do you need to know about the data available in the<br>Philippine Native Pig Breed Information System?</strong></h5>
                        <h4 style="text-decoration: underline;">The Project</h4>
                        <h5 style="text-align: justify;">The "Development of Philippine Native Pig Breed Information System" is a DOST-PCAARRD funded project of the Institute of Animal Science in cooperation with the Institute of Computer Science, University of the Philippines Los Ba&ntilde;os. The project aims to provide an accessible information source regarding selected Philippine Native Pig Breeds.</h5>
                        <h4 style="text-decoration: underline;">The Goal</h4>
                        <h5 style="text-align: justify;">The information in the website is accessible to the public and is hoped to be able to provide support for policy makers, community development practitioners, researchers, livestock keepers, and entrepreneurs towards native pig breed management.</h5>
                        <h5 style="text-align: justify;">On the other hand, there is a recording system feature of the website, which registered farmers can use.</h5>
                        <h4 style="text-decoration: underline;">The Data</h4>
                        <h5 style="text-align: justify;">The data available in this website include the morphological and reproductive performance traits of each native pig genetic group based on the records of the current breeders.</h5>
                        <h5 style="text-align: justify;">The following are the data collected:</h5>
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <ul class="collection with-header">
                                    <li class="collection-header"><h3>Qualitative Data</h3></li>
                                    <li class="collection-item"><h5>Hair type</h5></li>
                                    <li class="collection-item"><h5>Coat color and pattern</h5></li>
                                    <li class="collection-item"><h5>Shape of head</h5></li>
                                    <li class="collection-item"><h5>Ear type</h5></li>
                                    <li class="collection-item"><h5>Skin type</h5></li>
                                    <li class="collection-item"><h5>Backline</h5></li>
                                    <li class="collection-item"><h5>Tail type</h5></li>
                                </ul>
                            </div>
                            <div class="col s6 m6 l6">
                                <ul class="collection with-header">
                                    <li class="collection-header"><h3>Quantitative Data</h3></li>
                                    <li class="collection-item"><h5>Body weight</h5></li>
                                    <li class="collection-item"><h5>Head length</h5></li>
                                    <li class="collection-item"><h5>Body length</h5></li>
                                    <li class="collection-item"><h5>Pelvic width</h5></li>
                                    <li class="collection-item"><h5>Total teat number</h5></li>
                                    <li class="collection-item"><h5>Birth weight</h5></li>
                                    <li class="collection-item"><h5>Litter size</h5></li>
                                    <li class="collection-item"><h5>Number of males born</h5></li>
                                    <li class="collection-item"><h5>Number of females born</h5></li>
                                    <li class="collection-item"><h5>Age at weaning</h5></li>
                                    <li class="collection-item"><h5>Weaning weight</h5></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row center">
            <h5>Data included in this database were collected by the following:</h5>
        </div>
        <div class="row center">
            <div class="col s2 m2 l2">
                <img src="{{asset('images/bai.png')}}" height="100">
                <h5>Bureau of Animal Industry - National Swine and Poultry Research and Development Center (BAI-NSPRDC)</h5>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/bsu.png')}}" height="100">
                <h5>Benguet State University (BSU)</h5>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/essu.png')}}" height="100">
                <h5>Eastern Samar State University (ESSU)</h5>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/isu.png')}}" height="100">
                <h5>Isabela State University (ISU)</h5>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/ksu.png')}}" height="100">
                <h5>Kalinga State University (KSU)</h5>
            </div>
            <div class="col s2 m2 l2">
                <img src="{{asset('images/msc.png')}}" height="100">
                <h5>Marinduque State College (MSC)</h5>
            </div>
        </div>

         <footer class="page-footer green lighten-1">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <img src="{{asset('images/logo-swine.png')}}" height="175">
                        <h5 class="white-text" style="letter-spacing:-0.03em">Philippine Native Pig Breed Information System</h5>
                        <p class="grey-text text-lighten-4" style="text-align: justify;">The "Development of Philippine Native Pig Breed Information System" is a DOST-PCAARRD funded project of the Institute of Animal Science in cooperation with the Institute of Computer Science, University of the Philippines Los Ba&ntilde;os. The project aims to provide an accessible information source regarding selected Philippine Native Pig Breeds.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <img src="{{asset('images/dost.png')}}" height="70">
                        <img src="{{asset('images/pcaarrd.png')}}" height="70">
                        <img src="{{asset('images/uplb.png')}}" height="70"><br>
                        <img src="{{asset('images/ias.png')}}" height="80">
                        <img src="{{asset('images/ics.png')}}" height="70">
                        <img src="{{asset('images/logo-default.png')}}" height="70">
                    </div>
                </div>
            </div>
        </footer>
        <footer style="background:#efefef;color:#444;font-size:0.8em;margin:0;margin-top:-20px;margin-bottom:-20px;">
            <div class="container" style="padding-top:30px;">
                <div class="row">
                    <div class="m3 col">
                        <img src="http://www.pcaarrd.dost.gov.ph/home/portal/images/govph-seal-mono-footer.png"
                            width="200" />
                    </div>
                    <div class="m3 col">
                        Republic of the Philippines<br />
                        All content is in the public domain unless otherwise stated.
                    </div>
                    <div class="m3 col">
                        About GOVPH<br />
                        Learn more about the Philippine government, its structure, how government works and the people
                        behind it.
                        <br /><br />
                        <a href="https://www.gov.ph">Official Gazette</a><br />
                        <a href="https://data.gov.ph">Open Data Portal</a>
                    </div>
                    <div class="m3 col">
                        Government Links<br /><br />
                        <a href="http://president.gov.ph/">Office of the President</a><br />
                        <a href="http://ovp.gov.ph/">Office of the Vice President</a><br />
                        <a href="http://www.senate.gov.ph/">Senate of the Philippines</a><br />
                        <a href="http://www.congress.gov.ph/">House of Representatives</a><br />
                        <a href="http://sc.judiciary.gov.ph/">Supreme Court</a><br />
                        <a href="http://ca.judiciary.gov.ph/">Court of Appeals</a><br />
                        <a href="http://sb.judiciary.gov.ph/">Sandiganbayan</a><br />
                    </div>
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
            $(".dropdown-trigger").dropdown();
        </script>
    </body>

</html>
