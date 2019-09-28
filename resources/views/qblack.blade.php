<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: Q-Black</title>
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
                        <a href="{{url('/breed/q-black')}}" class="breadcrumb">Q-Black</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s2 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/q-black_grid.jpg')}}" height="130">
                    </div>
                    <div class="card-content">
                        Q-Black
                    </div>
                </div>
            </div>
            <div class="col s2 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/BSU-grid.jpg')}}" height="130">
                        <span class="card-title">Benguet Native Pig</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/benguet')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s2 m2">
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
            <div class="col s2 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/ISU-grid.jpeg')}}" height="130">
                        <span class="card-title">ISUbela</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/isubela')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s2 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/KSU-grid.jpeg')}}" height="130">
                        <span class="card-title">Yookah<sup>&reg;</sup></span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/yookah')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s2 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/MSC-grid.jpg')}}" height="130">
                        <span class="card-title">Markaduke</span>
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
                    <h3>Q-Black</h3>
                    <h5><strong>Location:</strong> Bureau of Animal Industry - National Swine and Poultry Research and Development Center<br>Lagalag, Tiaong, Quezon</h5>
                    <h5><strong>Contact Person:</strong> Rico M. Panaligan</h5>
                    <h5>Contact at <strong>(042) 585 7727</strong> / <strong>0997 693 2766</strong> or <strong>bai_nsprdc@yahoo.com</strong></h5>
                </div>
                <div class="col s6 m6 l6">
                    <div class="carousel">
                        <a class="carousel-item" href="#one!"><img src="{{asset('images/q-black.jpg')}}"></a>
                        <a class="carousel-item" href="#two!"><img src="{{asset('images/q-black-logo.png')}}"></a>
                        <a class="carousel-item" href="#three!"><img src="{{asset('images/bai.png')}}"></a>
                        <a class="carousel-item" href="#four!"><img src="{{asset('images/q-black2.jpg')}}"></a>
                        <a class="carousel-item" href="#five!"><img src="{{asset('images/q-black4.jpeg')}}"></a>
                    </div>
                </div>
                <h4 style="text-decoration: underline;">History</h4>
                <h5 style="text-align: justify;">The foundation stocks for the Q-Black breed is made up of three (3) junior boars and twelve (12) gilts acquired in 2014 from the municipalities of San Francisco, Mulanay, and San Andres in Bundok Peninsula of Quezon Province. The stocks are part of the Philippine Native Animal Development Program initiative on the conservation of native pigs implemented by BAI-NSPRDC, Tiaong, Quezon.</h5>
                <h5 style="text-align: justify;">Also in 2014, the DOST-PCAARRD funded project "Selection and Purification of Quezon Strain of Native Pigs" was initiated. A total of 30 heads of male and female weaners were selected from the offspring of the foundation stocks. These weaners were subjected to performance testing. The initial characteristics of Quezon Strain acquired at Bundok Peninsula were plain black with smooth skin and straight backline, semi-lop ear and an average mature weight of 76 kilograms. Formerly, the Quezon strain native pig was called "Bondoc Peninsula". The project agreed to change the trade name to Q-Black (Quezon Black) Native Pig.</h5>
            </div>
            <div class="row">
                <h4 style="text-decoration: underline;">Morphology</h4>
                <div class="col s12">
                    <ul class="tabs smalltabs">
                        <li class="tab col s2 offset-s4"><a href="#narrative"><i class="material-icons">format_align_justify</i></a></li>
                        <li class="tab col s2"><a href="#figures"><i class="material-icons">border_all</i></a></li>
                    </ul>
                </div>
                <div id="narrative" class="col s12">
                    <div class="row">
                        <h5 style="text-align: justify;">Both male and female Q-Black native pigs have straight hair type, plain black coat, and smooth skin type. They have straight head shape, tail type, and backline. Their ears are semi-lop.</h5>
                        <h5 style="text-align: justify;">On average, the mature pig grows to 77 centimeters in length for males and 79 centimeters for females, with head length of 24 centimeters for both males and females.</p>
                        <h5 style="text-align: justify;">Pelvic width is 22 centimters for females. The average number of teats are 12 for both males and females.</h5>
                    </div>
                </div>
                <div id="figures" class="col s12">
                    <div class="row center">
                        <h5><strong>Straight Hair | Plain Black Coat | Straight Head | Smooth Skin | Semi-lop Ears | Straight Tail | Straight Backline</strong></h5>
                    </div>
                    <div class="row">
                        <table>
                            <thead>
                                <tr>
                                    <th><h5>Morphology</h5></th>
                                    <th class="center"><h5>Male</h5></th>
                                    <th class="center"><h5>Female</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><h5>Body Weight at 180 Days, kg</h5></td>
                                    <td class="center"><h5>36.86 &plusmn; 5.68</h5></td>
                                    <td class="center"><h5>31.24 &plusmn; 1.81</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Head Length, cm</h5></td>
                                    <td class="center"><h5>24.38 &plusmn; 1.32</h5></td>
                                    <td class="center"><h5>24.31 &plusmn; 6.24</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Body Length, cm</h5></td>
                                    <td class="center"><h5>77.19 &plusmn; 5.67</h5></td>
                                    <td class="center"><h5>79.27 &plusmn; 11.18</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Pelvic Width, cm</h5></td>
                                    <td class="center"><h5>31.33 &plusmn; 7.48</h5></td>
                                    <td class="center"><h5>22.18 &plusmn; 2.61</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Number of Normal Teats</h5></td>
                                    <td class="center"><h5>12.00 &plusmn; 1.60</h5></td>
                                    <td class="center"><h5>11.46 &plusmn; 0.37</h5></td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="center">*data as of March, 2019</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4 style="text-decoration: underline;">Reproductive Performance</h4>
                <div class="col s12">
                    <ul class="tabs smalltabs">
                        <li class="tab col s2 offset-s4"><a href="#narrative2"><i class="material-icons">format_align_justify</i></a></li>
                        <li class="tab col s2"><a href="#figures2"><i class="material-icons">border_all</i></a></li>
                    </ul>
                </div>
                <div id="narrative2" class="col s12">
                    <div class="row">
                        <h5 style="text-align: justify;">The Q-Black sows farrow 7 piglets, weighing 0.84 kilogram on average. The male and female piglets at birth are usually of the same number. The average weaning weight is 4.79 kilograms at 43-47 days old.</h5>
                    </div>
                </div>
                <div id="figures2" class="col s12">
                    <div class="row" style="padding-top: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td><h5>Birth Weight, kg</h5></td>
                                    <td class="center"><h5>0.84 &plusmn; 0.05</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Littersize at Birth</h5></td>
                                    <td class="center"><h5>6.42 &plusmn; 1.72</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Number of Males</h5></td>
                                    <td class="center"><h5>3.02 &plusmn; 1.28</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Number of Females</h5></td>
                                    <td class="center"><h5>3.37 &plusmn; 1.51</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Weaning Weight, kg</h5></td>
                                    <td class="center"><h5>4.79 &plusmn; 0.79</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Age at Weaning, days</h5></td>
                                    <td class="center"><h5>45.21 &plusmn; 1.95</h5></td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="center">*data as of March, 2019</h6>
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