<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: ISUbela</title>
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
                        <a href="{{url('/breed/isubela')}}" class="breadcrumb">ISUbela</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/ISU-grid.JPG')}}" height="130">
                    </div>
                    <div class="card-content">
                        ISUbela
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
                        <img src="{{asset('images/KSU-grid.JPG')}}" height="130">
                        <span class="card-title">Yookah<sup>&reg;</sup></span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/yookah')}}">View</a>
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
                    <h3>ISUbela</h3>
                    <p><strong>Location:</strong> Isabela State University (San Fabian, Echague, Isabela)</p>
                    <p><strong>Contact Person:</strong> Dr. Joel L. Reyes</p>
                    <p>Contact at <strong>0917 362 5996</strong> or <strong>joellreyes@yahoo.com</strong></p>
                </div>
                <div class="col s6 m6 l6">
                    <div class="carousel">
                        <a class="carousel-item" href="#one!"><img src="{{asset('images/isubela.jpg')}}"></a>
                        <a class="carousel-item" href="#two!"><img src="{{asset('images/isubela-logo.jpg')}}"></a>
                        <a class="carousel-item" href="#three!"><img src="{{asset('images/isu.png')}}"></a>
                        <a class="carousel-item" href="#four!"><img src="{{asset('images/isubela_grid.jpg')}}"></a>
                    </div>
                </div>
                <h5 style="text-decoration: underline;">History</h5>
                <p style="text-align: justify;">ISUbela native pig is the trade name which has been applied to the developed genetic group developed by the Isabela State University (ISU).</p>
                <p style="text-align: justify;">In 2013, researchers from ISU went around the far-flung barangays of Isabela province to purchase native pigs reared in the communities. These native pigs were then observed to be pure black in color with straight back, while some have white socks with swayed back. Majority, however, were pure black.</p>
                <p style="text-align: justify;">In 2016, the researchers decided to focus on selecting and purifying the pure black strain since most of the Isabela native pigs are pure black. Breeding and selection started with phenotypically pure black male and female animals with not less than 12 teats.</p>
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
                        <p style="text-align: justify;">Both male and female ISUbela native pigs have straihght and long hair type, plain black pattern and color, smooth skin type, and erect ears. They have straight head shape, tail type, and backline.</p>
                        <p style="text-align: justify;">On average, the mature pig grows to 59 centimeters in length for males and 61 centimeters for females with pelvic width of 16 centimeters for males and 18 centimeters for females. Both males and females have and average of 12 teats.</p>
                    </div>
                </div>
                <div id="figures" class="col s12">
                    <div class="row center">
                        <h6><strong>Straight and Long Hair | Plain Black Coat | Straight Head | Smooth Skin | Erect Ears for Male and Erect or Semi-lop Ears for Female | Straight Tail | Straight Backline</strong></h6>
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
                                    <td class="center">20.25 &plusmn; 3.37</td>
                                    <td class="center">20.78 &plusmn; 5.97</td>
                                </tr>
                                <tr>
                                    <td>Body Length, cm</td>
                                    <td class="center">58.58 &plusmn; 7.12</td>
                                    <td class="center">60.76 &plusmn; 13.33</td>
                                </tr>
                                <tr>
                                    <td>Pelvic Width, cm</td>
                                    <td class="center">15.83 &plusmn; 2.91</td>
                                    <td class="center">18.19 &plusmn; 3.59</td>
                                </tr>
                                <tr>
                                    <td>Number of Normal Teats</td>
                                    <td class="center">12.33 &plusmn; 0.62</td>
                                    <td class="center">11.62 &plusmn; 1.33</td>
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
                        <p style="text-align: justify;">ISUbela sows farrow 8 piglets, weighing 0.77 kilogram on average. The male and female piglets at birth are usually of the same number. The average weaning weight is 3 kilograms at 34 days old.</p>
                    </div>
                </div>
                <div id="figures2" class="col s12">
                    <div class="row" style="padding-top: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Birth Weight, kg</td>
                                    <td class="center">0.77 &plusmn; 0.17</td>
                                </tr>
                                <tr>
                                    <td>Littersize at Birth</td>
                                    <td class="center">7.70 &plusmn; 1.63</td>
                                </tr>
                                <tr>
                                    <td>Number of Males</td>
                                    <td class="center">3.84 &plusmn; 1.32</td>
                                </tr>
                                <tr>
                                    <td>Number of Females</td>
                                    <td class="center">3.86 &plusmn; 1.35</td>
                                </tr>
                                <tr>
                                    <td>Weaning Weight, kg</td>
                                    <td class="center">3.02 &plusmn; 0.74</td>
                                </tr>
                                <tr>
                                    <td>Age at Weaning, days</td>
                                    <td class="center">33.76 &plusmn; 4.66</td>
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