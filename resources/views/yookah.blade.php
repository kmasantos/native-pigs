<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: Yookah&reg;</title>
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
                        <a href="{{url('/breed/yookah')}}" class="breadcrumb">Yookah<sup>&reg;</sup></a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/KSU-grid.JPG')}}" height="130">
                    </div>
                    <div class="card-content">
                        Yookah<sup>&reg;</sup>
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
                        <img src="{{asset('images/BSU-grid.jpg')}}" height="130">
                        <span class="card-title">Benguet Native Pig</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/benguet')}}">View</a>
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
                        <img src="{{asset('images/ISU-grid.JPG')}}" height="130">
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
                    <h3>Yookah<sup>&reg;</sup></h3>
                    <h5><strong>Location:</strong> Kalinga State University<br>Bulanao, Tabuk City, Kalinga</h5>
                    <h5><strong>Contact Person:</strong> Sharmaine D. Codiam</h5>
                    <h5>Contact at <strong>0927 722 4283</strong></h5>
                </div>
                <div class="col s6 m6 l6">
                    <div class="carousel">
                        <a class="carousel-item" href="#one!"><img src="{{asset('images/yookah.jpg')}}"></a>
                        <a class="carousel-item" href="#two!"><img src="{{asset('images/yookah-logo.png')}}"></a>
                        <a class="carousel-item" href="#three!"><img src="{{asset('images/ksu.png')}}"></a>
                        <a class="carousel-item" href="#four!"><img src="{{asset('images/yookah2.jpg')}}"></a>
                        <a class="carousel-item" href="#five!"><img src="{{asset('images/yookah3.jpg')}}"></a>
                    </div>
                </div>
                <h4 style="text-decoration: underline;">History</h4>
                <h5 style="text-align: justify;">"Yookah" [juka] [yooka] [yuka] is a brand name used for purified native pigs produced in KSU Native Pig R&D Station. This was the result of the DOST-PCAARRD funded project on the breeding of true to type native pig populations.</h5>
                <h5 style="text-align: justify;">Thirty (30) native pig foundation stocks with twenty-five (25) females and five (5) males were randomly selected and procured from villages in the Province of Kalinga. These foundation stocks underwent intensive breeding and selection. Through regular conduct of phenotypic characterization of the native pig herd at the KSU station, black coat color with white stockings are relatively high in number.</h5>
                <h5 style="text-align: justify;">"Borok [bɔrɔk] or Forok [fɔrɔk]" is the common term for pigs (whether native or not) in Kalinga Province. However, with the association of the term "Yookah" to Kalinga native pigs, the KSU Native Pig R&D Project adopted this name. Thus, it provides familiarity to the brand name of Kalinga Native Pigs and it gives recognition of the history of the term.</h5>
                <h5 style="text-align: justify;">The name "Yookah" is a symbolic word which means, "you come" or "you come and eat". In raising their native pigs for instance, the <i>Ikalingas</i> especially from the far-flung areas, do not build pig pens rather they practice the free-range method. Because of this, they devised a strategy of calling out to their native pigs during feeding time. Early in the morning and before twilight, the raisers will shout, "Yookah" until all their pigs approach them for feeding. This is why the Kalinga folks started calling their native pigs, "Yookah".</h5>
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
                        <h5 style="text-align: justify;">Both male and female Yookah<sup>&reg;</sup> native pigs have straight and long hair type, black coat with white socks, smooth skin type, and erect ears. They have straight head shape, tail type, and backline.</h5>
                        <h5 style="text-align: justify;">On average, the mature pig grows to 58 centimeters in length for males and 55 centimeters for females, with head length of 27 centimeters for males and 23 centimeters for females.</h5>
                        <h5 style="text-align: justify;">Pelvic width is 13 centimeters for both males and females. Likewise, both have an average of 10 teats.</h5>
                    </div>
                </div>
                <div id="figures" class="col s12">
                    <div class="row center">
                        <h5><strong> Straight and Long Hair |  Black Coat with White Socks |  Straight Head | Smooth Skin | Erect Ears | Straight Tail | Straight Backline</strong></h5>
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
                                    <td class="center"><h5>14.90 &plusmn; 0.89</h5></td>
                                    <td class="center"><h5>15.38 &plusmn; 2.85</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Head Length, cm</h5></td>
                                    <td class="center"><h5>26.67 &plusmn; 4.75</h5></td>
                                    <td class="center"><h5>23.27 &plusmn; 2.57</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Body Length, cm</h5></td>
                                    <td class="center"><h5>57.83 &plusmn; 10.81</h5></td>
                                    <td class="center"><h5>54.53 &plusmn; 10.40</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Pelvic Width, cm</h5></td>
                                    <td class="center"><h5>12.83 &plusmn; 2.11</h5></td>
                                    <td class="center"><h5>13.00 &plusmn; 1.59</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Number of Normal Teats</h5></td>
                                    <td class="center"><h5>10.33 &plusmn; 0.75</h5></td>
                                    <td class="center"><h5>10.13 &plusmn; 0.50</h5></td>
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
                        <h5 style="text-align: justify;">Yookah<sup>&reg;</sup> sows farrow 4 piglets, weighing 0.5 kilogram on average. The male and female piglets at birth are usually of the same number. The average weaning weight is 4.75 kilograms at 67 days of age.</h5>
                    </div>
                </div>
                <div id="figures2" class="col s12">
                    <div class="row" style="padding-top: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td><h5>Birth Weight, kg</h5></td>
                                    <td class="center"><h5>0.49 &plusmn; 0.20</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Littersize at Birth</h5></td>
                                    <td class="center"><h5>3.54 &plusmn; 1.22</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Number of Males</h5></td>
                                    <td class="center"><h5>1.77 &plusmn; 0.98</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Number of Females</h5></td>
                                    <td class="center"><h5>1.75 &plusmn; 0.78</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Weaning Weight, kg</h5></td>
                                    <td class="center"><h5>4.75 &plusmn; 1.36</h5></td>
                                </tr>
                                <tr>
                                    <td><h5>Age at Weaning, days</h5></td>
                                    <td class="center"><h5>66.64 &plusmn; 23.36</h5></td>
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