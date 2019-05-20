<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: Native Pig of MSC</title>
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
                        <a href="{{url('/breed/marinduke')}}" class="breadcrumb">Native Pig of MSC</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/marinduke_grid.jpg')}}" height=130">
                    </div>
                    <div class="card-content">
                        Native Pig of MSC
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
                        <img src="{{asset('images/benguet_grid.jpg')}}" height="130">
                        <span class="card-title">Benguet</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/benguet')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/sinirangan_grid.jpg')}}" height=130">
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
                        <img src="{{asset('images/isubela_grid.jpg')}}" height=130">
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
                        <img src="{{asset('images/yookah_grid.jpg')}}" height=130">
                        <span class="card-title">Yookah</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/yookah')}}">View</a>
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
                    <h3>Native Pig of MSC</h3>
                    <p><strong>Location:</strong> Marinduque State College (Poctoy, Torrijos, Marinduque)</p>
                    <p><strong>Contact Person:</strong> Randell R. Reginio</p>
                    <p>Contact at <strong>0999 924 5638</strong> or <strong>randell_reginio@yahoo.com</strong></p>
                </div>
                <div class="col s6 m6 l6">
                    <div class="carousel">
                        <a class="carousel-item" href="#one!"><img src="{{asset('images/marinduke.jpg')}}"></a>
                        <a class="carousel-item" href="#two!"><img src="{{asset('images/msc.png')}}" height="95%" width="95%"></a>
                        <a class="carousel-item" href="#three!"><img src="{{asset('images/marinduke_grid.jpg')}}"></a>
                        <a class="carousel-item" href="#four!"><img src="{{asset('images/marinduke_grid2.jpg')}}"></a>
                        <a class="carousel-item" href="#five!"><img src="{{asset('images/marinduke3.jpg')}}"></a>
                    </div>
                </div>
                <h5 style="text-decoration: underline;">History</h5>
                <p style="text-align: justify;">On November 2012, the Marinduque State College purchased one male and two female native pigs. These numbers increased to 42 heads by 2014. Additional 38 native pigs (2 males and 36 females) were purchased from the municipalities of Santa Cruz, Mogpog, and Boac through the DOST-PCAARRD R&D Program on Conservation, Improvement, and Profitable Utilization of Philippine Native Pig.</p>
                <p style="text-align: justify;">Now, the Marinduque State College has a population of 50 sows and 10 boars; and 50 selected females in the nucleus herd.</p>
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
                        <p style="text-align: justify;">Both male and female native pigs from MSC have straight hair type, plain black color and pattern, smooth skin type, and semi-lop ears. They have straight head shape, tail type, and backline.</p>
                        <p style="text-align: justify;">On average, the mature pig grows to 67 centimeters in length for both males and females with head length of 28 centimeters for males and 27 centimeters for females.</p>
                        <p style="text-align: justify;">Pelvic width is 13 centimeters for both males and females. Both males and females also have an average of 13 teats.</p>
                    </div>
                </div>
                <div id="figures" class="col s12">
                    <div class="row center">
                        <h6><strong>Straight Hair | Plain Black Coat | Straight Head | Smooth Skin | Semi-lop Ears | Straight Tail | Straight Backline</strong></h6>
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
                                    <td>Body Weight at 180 Days, kg</td>
                                    <td class="center">28.16 &plusmn; 11.34</td>
                                    <td class="center">25.22 &plusmn; 8.33</td>
                                </tr>
                                <tr>
                                    <td>Head Length, cm</td>
                                    <td class="center">28.25 &plusmn; 4.13</td>
                                    <td class="center">26.89 &plusmn; 2.85</td>
                                </tr>
                                <tr>
                                    <td>Body Length, cm</td>
                                    <td class="center">67.57 &plusmn; 9.83</td>
                                    <td class="center">67.02 &plusmn; 10.47</td>
                                </tr>
                                <tr>
                                    <td>Pelvic Width, cm</td>
                                    <td class="center">12.92 &plusmn; 1.64</td>
                                    <td class="center">13.07 &plusmn; 2.27</td>
                                </tr>
                                <tr>
                                    <td>Number of Normal Teats</td>
                                    <td class="center">13.93 &plusmn; 1.49</td>
                                    <td class="center">13.22 &plusmn; 1.30</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <h5 style="text-decoration: underline;">Reproductive Performance</h5>
                <div class="col s12">
                    <ul class="tabs smalltabs">
                        <li class="tab col s2 offset-s4"><a href="#narrative2"><i class="material-icons">format_align_justify</i></a></li>
                        <li class="tab col s2"><a href="#figures2"><i class="material-icons">border_all</i></a></li>
                    </ul>
                </div>
                <div id="narrative2" class="col s12">
                    <div class="row">
                        <p style="text-align: justify;">Native sows of MSC farrow 7 piglets, weighing 0.74 kilogram on average. The average weaning weight is 3.65 kilograms at 43 days old.</p>
                    </div>
                </div>
                <div id="figures2" class="col s12">
                    <div class="row" style="padding-top: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Birth Weight, kg</td>
                                    <td class="center">0.74 &plusmn; 0.14</td>
                                </tr>
                                <tr>
                                    <td>Littersize at Birth</td>
                                    <td class="center">7.23 &plusmn; 2.16</td>
                                </tr>
                                <tr>
                                    <td>Number of Males</td>
                                    <td class="center">3.08 &plusmn; 1.51</td>
                                </tr>
                                <tr>
                                    <td>Number of Females</td>
                                    <td class="center">3.77 &plusmn; 1.54</td>
                                </tr>
                                <tr>
                                    <td>Weaning Weight, kg</td>
                                    <td class="center">3.65 &plusmn; 1.07</td>
                                </tr>
                                <tr>
                                    <td>Age at Weaning, days</td>
                                    <td class="center">42.68 &plusmn; 1.51</td>
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