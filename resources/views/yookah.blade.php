<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: Yookah</title>
        <link rel="shortcut icon" href="{{asset('images/logo-swine-square.png')}}" />

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
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{url('login/google')}}">Login</a></li>
                    </ul>
                </div>
                <div class="row green lighten-1">
                    <div class="col s12">
                        <a href="{{url('/')}}" class="breadcrumb">Home</a>
                        <a href="{{url('/#breeds')}}" class="breadcrumb">Breeds</a>
                        <a href="{{url('/breed/yookah')}}" class="breadcrumb">Yookah</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 100px;">
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/yookah.jpg')}}" width="50">
                    </div>
                    <div class="card-content">
                        Yookah
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/q-black.jpg')}}" height="130">
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
                        <img src="{{asset('images/benguet.jpg')}}" height="130">
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
                        <img src="{{asset('images/sinirangan.jpg')}}" width="50">
                        <span class="card-title">Sinirangan</span>
                    </div>
                    <div class="card-content">
                        <a href="{{url('/breed/sinirangan')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/isubela.jpg')}}" width="50">
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
                        <img src="{{asset('images/marinduke.jpg')}}" width="50">
                        <span class="card-title">Native Pig of Marinduque</span>
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
                <h3>Yookah</h3>
                <p><strong>Location:</strong> Kalinga State University (Bulanao, Tabuk City, Kalinga)</p>
                <p><strong>Contact Person:</strong> Sharmaine D. Codiam</p>
                <p>Contact at <strong>0927 722 4283</strong></p>
            </div>
            <div class="row center">
                <h6><strong> Straight and Long Hair |  Black Coat with White Socks |  Straight Head | Smooth Skin | Erect Ears | Straight Tail | Straight Backline</strong></h6>
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
                            <td class="center">14.90 &plusmn; 0.89</td>
                            <td class="center">15.38 &plusmn; 2.85</td>
                        </tr>
                        <tr>
                            <td>Body Length, cm</td>
                            <td class="center">57.83 &plusmn; 10.81</td>
                            <td class="center">54.53 &plusmn; 10.40</td>
                        </tr>
                        <tr>
                            <td>Number of Normal Teats</td>
                            <td class="center">10.33 &plusmn; 0.75</td>
                            <td class="center">10.13 &plusmn; 0.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" style="padding-top: 10px;">
                <h6><strong>Reproductive Performance</strong></h6>
                <table>
                    <tbody>
                        <tr>
                            <td>Birth Weight, kg</td>
                            <td class="center">0.49 &plusmn; 0.20</td>
                        </tr>
                        <tr>
                            <td>Littersize at Birth</td>
                            <td class="center">3.54 &plusmn; 1.22</td>
                        </tr>
                        <tr>
                            <td>Weaning Weight, kg</td>
                            <td class="center">4.75 &plusmn; 1.36</td>
                        </tr>
                        <tr>
                            <td>Age at Weaning, days</td>
                            <td class="center">66.64 &plusmn; 23.36</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>