<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: Benguet</title>
        <link rel="shortcut icon" href="{{asset('images/logo-swine-square.png')}}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize.min.css')}}"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
        <style>
            .tabs .tab a {
                color: #000000 !important;
            }

            .tabs .indicator {
                height: 5px;
                background-color: #1B5E20 !important;
            }

            .tabs .tab a:hover {
                background-color: #81C784;
            }

            .tabs .tab a.active {
                background-color: #43A047;
            }

            .smalltabs .tab a.active {
                background-color: transparent;
            }

            .smalltabs .tab a:hover {
                background-color: #f5f5f5;
            }
        </style>
        {{-- <link rel="stylesheet" href="{{asset('css/global.css')}}"> --}}
        {{-- <link type="text/css" rel="stylesheet" href="{{asset('css/pig.css')}}"  media="screen,projection"/> --}}
    </head>
    <body>
        <div class="navbar-fixed">
            <nav class="green lighten-1" role="navigation">
                <div class="nav-wrapper">
                    <a href={{ url('/') }} class="brand-logo"><img src="{{asset('images/logo-swine.png')}}" alt="Native Pigs" height="65" / ></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{url('login/google')}}">Login</a></li>
                    </ul>
                </div>
                <div class="row green lighten-1">
                    <div class="col s12">
                        <a href="{{url('/')}}" class="breadcrumb">Home</a>
                        <a href="{{url('/#breeds')}}" class="breadcrumb">Breeds</a>
                        <a href="{{url('/breed/benguet')}}" class="breadcrumb">Benguet</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/benguet_grid.jpg')}}" height="130">
                    </div>
                    <div class="card-content">
                        Benguet
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/q-black_grid.jpg')}}" height="130">
                        <span class="card-title">Q-Black</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/q-black')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/sinirangan_grid.jpg')}}" height="130">
                        <span class="card-title">Sinirangan<sup>&reg;</sup></span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/sinirangan')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/isubela_grid.jpg')}}" height="130">
                        <span class="card-title">ISUbela</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/isubela')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/yookah_grid.jpg')}}" height="130">
                        <span class="card-title">Yookah</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/yookah')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/marinduke_grid.jpg')}}" height="130">
                        <span class="card-title">Native Pig of MSC</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/marinduke')}}">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="divider"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s6 m6 l6">
                    <h3>Benguet</h3>
                    <p><strong>Location:</strong>The Animal Genetic Resource Project - Benguet State University (La Trinidad, Benguet)</p>
                    <p><strong>Contact Person:</strong> Dr. Sonwright B. Maddul</p>
                    <p>Contact at <strong>0929 316 3996</strong> / <strong>0916 364 2039</strong></p>
                </div>
                <div class="col s6 m6 l6">
                    <div class="carousel">
                        <a class="carousel-item" href="#one!"><img src="{{asset('images/benguet.jpg')}}"></a>
                        <a class="carousel-item" href="#two!"><img src="{{asset('images/benguet-logo.png')}}"></a>
                        <a class="carousel-item" href="#three!"><img src="{{asset('images/bsu.png')}}"></a>
                    </div>
                </div>
                <h5 style="text-decoration: underline;">History</h5>
                <p style="text-align: justify;">The Benguet Native Pig is a product of the PCAARRD-funded multi-agency R&D project, "Conservation, Improvement, and Profitable Utilization of the Philippine Native Pigs", which was first implemented in 2014. Benguet State University, being one of the cooperating stations, envisioned to establish a breeding true-to-type native pig population in the Cordillera Administrative Region.</p>
                <p style="text-align: justify;">Breeders were selected from different municipalities in Benguet on the following criteria: solid black coat, small erect ears, cylindrical snout, and straight tail. Number of teats, back and feet conformation and body length are secondary traits for selection. Using the natural method of breeding a series of mating was done until a true-to-type black pig was produced. The mature Benguet Native Pig has solid black coat, dense hair, erect ears, straight back, and at least six pairs of teats. A dense mane/coat with brown hair is present along the poll towards the lumbar area.</p>
            </div>
            <div class="row">
                <h5 style="text-decoration: underline;">Morphology</h5>
                <div class="col s12">
                    <ul class="tabs smalltabs">
                        <li class="tab col s2 offset-s4"><a href="#narrative"><i class="material-icons">format_align_justify</i></a></li>
                        <li class="tab col s2"><a href="#figures"><i class="material-icons">border_all</i></a></li>
                    </ul>
                </div>
                <div id="narrative" class="col s12">
                    <div class="row">
                        <p style="text-align: justify;">Both male and female Benguet native pigs have straight and long hair type, solid black color, smooth skin type, and erect ears. They have straight head shape, tail, and backline. The males have an average of 12 teats, while females have 11.</p>
                    </div>
                </div>
                <div id="figures" class="col s12">
                    <div class="row center">
                        <h6><strong>Straight and Long Hair | Plain Black Coat | Straight Head | Smooth Skin | Erect Ears | Straight Tail | Straight Backline</strong></h6>
                    </div>
                    <div class="row">
                        <table>
                            <thead>
                                <tr>
                                    <th>Morphology</th>
                                    <th class="center">Male</th>
                                    <th class="center">Female</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Body Weight at 240 Days, kg</td>
                                    <td class="center">42.00</td>
                                    <td class="center">38.20 &plusmn; 11.21</td>
                                </tr>
                                <tr>
                                    <td>Head Length, cm</td>
                                    <td class="center">27.00</td>
                                    <td class="center">21.60 &plusmn; 1.36</td>
                                </tr>
                                <tr>
                                    <td>Body Length, cm</td>
                                    <td class="center">70.00</td>
                                    <td class="center">67.00 &plusmn; 9.21</td>
                                </tr>
                                <tr>
                                    <td>Pelvic Width, cm</td>
                                    <td class="center">22.00</td>
                                    <td class="center">15.00 &plusmn; 2.10</td>
                                </tr>
                                <tr>
                                    <td>Number of Normal Teats</td>
                                    <td class="center">12.00</td>
                                    <td class="center">11.40 &plusmn; 0.80</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <h5 style="text-decoration: underline;">Reproductive Traits</h5>
                <div class="col s12">
                    <ul class="tabs smalltabs">
                        <li class="tab col s2 offset-s4"><a href="#narrative2"><i class="material-icons">format_align_justify</i></a></li>
                        <li class="tab col s2"><a href="#figures2"><i class="material-icons">border_all</i></a></li>
                    </ul>
                </div>
                <div id="narrative2" class="col s12">
                    <div class="row">
                        <p style="text-align: justify;">Benguet sow farrow 8 piglets, weighing 0.77 kilogram on average. The average weaning weight is 4.9 kilograms at 60 days of age.</p>
                    </div>
                </div>
                <div id="figures2" class="col s12">
                    <div class="row" style="padding-top: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Birth Weight, kg</td>
                                    <td class="center">0.77 &plusmn; 0.12</td>
                                </tr>
                                <tr>
                                    <td>Littersize at Birth</td>
                                    <td class="center">8.17 &plusmn; 3.24</td>
                                </tr>
                                <tr>
                                    <td>Number of Males</td>
                                    <td class="center">4.17 &plusmn; 2.21</td>
                                </tr>
                                <tr>
                                    <td>Number of Females</td>
                                    <td class="center">3.13 &plusmn; 1.52</td>
                                </tr>
                                <tr>
                                    <td>Weaning Weight, kg</td>
                                    <td class="center">4.90 &plusmn; 1.80</td>
                                </tr>
                                <tr>
                                    <td>Age at Weaning, days</td>
                                    <td class="center">59.59 &plusmn; 10.40</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tabs').tabs();
        });
        $(document).ready(function(){
            $('.carousel').carousel();
        });
    </script>
</html>