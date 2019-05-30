<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: Sinirangan&reg;</title>
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
                        <a href="{{url('/breed/sinirangan')}}" class="breadcrumb">Sinirangan<sup>&reg;</sup></a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/sinirangan_grid.jpg')}}" height="130">
                    </div>
                    <div class="card-content">
                        Sinirangan<sup>&reg;</sup>
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
                        <img src="{{asset('images/KSU-grid.JPG')}}" height="130">
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
                        <img src="{{asset('images/MSC-grid.jpg')}}" height="130">
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
                    <h3>Sinirangan<sup>&reg;</sup></h3>
                    <p><strong>Location:</strong> Eastern Samar State University (Borongan Campus)</p>
                    <p><strong>Address:</strong> ESSU Sinirangan<sup>&reg;</sup> Pig Center, Sitio Diyo, Brgy. Tabunan, Borongan City, Eastern Samar 6800</p>
                    <p><strong>Contact Person:</strong> Dr. Felix A. Afable / Dr. Sharon B. Singzon</p>
                    <p>Contact at <strong>essuphilnativepig@gmail.com</strong></p>
                </div>
                <div class="col s6 m6 l6">
                    <div class="carousel">
                        <a class="carousel-item" href="#one!"><img src="{{asset('images/sinirangan.jpg')}}"></a>
                        <a class="carousel-item" href="#two!"><img src="{{asset('images/sinirangan-logo.png')}}"></a>
                        <a class="carousel-item" href="#three!"><img src="{{asset('images/essu.png')}}"></a>
                        <a class="carousel-item" href="#four!"><img src="{{asset('images/sinirangan2.jpg')}}"></a>
                        <a class="carousel-item" href="#five!"><img src="{{asset('images/sinirangan3.jpg')}}"></a>
                    </div>
                </div>
                <h5 style="text-decoration: underline;">History</h5>
                <p style="text-align: justify;">More than 10 years ago, native pigs were introduced into the Eastern Samar State University's farm in Sitio Diyo of Brgy. Tabunan in Borongan City. The farm used to be an orchard which had yearly typhoons destroying many of its fruit trees. Thus, it became transformed into a cogon dominated area where native pig breeds thrived.</p>
                <p style="text-align: justify;">The pigs were raised under an extensive management system. They were free-range pigs roaming the grasslands and areas under the fruit trees. Even with minimal human intervention, they grew and survived. Native pigs are prefered in Borongan as lechon during special occasions.</p>
                <p style="text-align: justify;">In 2015, DOST-PCAARRD funded a native pig conservation and improvement project, where native pigs from various locations in Region 8 were bought and mated with the original stocks. Afterwhich, selection and breeding were done to produce the Sinirangan<sup>&reg;</sup> native pig.</p>
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
                        <p style="text-align: justify;">Both male and female of the Sinirangan<sup>&reg;</sup> breed have straight hair type, black coat, and smooth skin type. They have straight head shape, tail type, and backline, and erect ears. Body weight at 180 days is from 18 to 23 kilograms for males. However, females are heavier, weighing 21 to 28 kilograms.</p>
                        <p style="text-align: justify;">The mature pig grows to about 59 to 67 centimeters in length for males and 59 to 69 centimeters for females. The head length and pelvic width on average is 26 centimeters and 19 centimeters, respectively, in both sexes. The average teat number is 12.</p>
                    </div>
                </div>
                <div id="figures" class="col s12">
                    <div class="row center">
                        <h6><strong>Straight Hair | Plain Black Coat | Straight Head | Smooth Skin | Erect Ears | Straight Tail | Straight Backline</strong></h6>
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
                                    <td class="center">20.47 &plusmn; 2.96</td>
                                    <td class="center">24.40 &plusmn; 3.38</td>
                                </tr>
                                <tr>
                                    <td>Head Length, cm</td>
                                    <td class="center">26.67 &plusmn; 1.37</td>
                                    <td class="center">25.70 &plusmn; 1.79</td>
                                </tr>
                                <tr>
                                    <td>Pelvic Width, cm</td>
                                    <td class="center">18.33 &plusmn; 1.89</td>
                                    <td class="center">18.90 &plusmn; 1.50</td>
                                </tr>
                                <tr>
                                    <td>Number of Normal Teats</td>
                                    <td class="center">12.33 &plusmn; 0.94</td>
                                    <td class="center">11.50 &plusmn; 0.80</td>
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
                        <p style="text-align: justify;">Sinirangan<sup>&reg;</sup> sows farrow 3 to 8 piglets, weighing 0.50 kilogram on average at birth. Interestingly, there are more males than females in a litter. At forty-eight (48) days of age, weaning weight is 2.44 kilograms.</p>
                    </div>
                </div>
                <div id="figures2" class="col s12">
                    <div class="row" style="padding-top: 10px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Birth Weight, kg</td>
                                    <td class="center">0.50 &plusmn; 0.07</td>
                                </tr>
                                <tr>
                                    <td>Littersize at Birth</td>
                                    <td class="center">5.35 &plusmn; 2.63</td>
                                </tr>
                                <tr>
                                    <td>Number of Males</td>
                                    <td class="center">3.13 &plusmn; 1.91</td>
                                </tr>
                                <tr>
                                    <td>Number of Females</td>
                                    <td class="center">2.44 &plusmn; 1.14</td>
                                </tr>
                                <tr>
                                    <td>Weaning Weight, kg</td>
                                    <td class="center">2.44 &plusmn; 1.59</td>
                                </tr>
                                <tr>
                                    <td>Age at Weaning, days</td>
                                    <td class="center">48.5 &plusmn; 4.55</td>
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