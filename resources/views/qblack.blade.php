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
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/q-black.jpg')}}" height="130">
                    </div>
                    <div class="card-content">
                        Q-Black
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
                        <a href="{{url('/breed/sinirangan')}}">View</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m2">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('images/yookah.jpg')}}" width="50">
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
                <h3>Q-Black</h3>
                <p><strong>Location:</strong> Bureau of Animal Industry - National Swine and Poultry Research and Development Center (Lagalag, Tiaong, Quezon)</p>
                <p><strong>Contact Person:</strong> Rico M. Panaligan</p>
                <p>Contact at <strong>(042) 585 7727</strong> / <strong>0997 693 2766</strong> or <strong>bai_nsprdc@yahoo.com</strong></p>
            </div>
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
                            <td class="center">36.86 &plusmn; 5.68</td>
                            <td class="center">31.24 &plusmn; 1.81</td>
                        </tr>
                        <tr>
                            <td>Body Length, cm</td>
                            <td class="center">77.19 &plusmn; 5.67</td>
                            <td class="center">79.27 &plusmn; 11.18</td>
                        </tr>
                        <tr>
                            <td>Number of Normal Teats</td>
                            <td class="center">12.00 &plusmn; 1.60</td>
                            <td class="center">11.46 &plusmn; 0.37</td>
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
                            <td class="center">0.84 &plusmn; 0.05</td>
                        </tr>
                        <tr>
                            <td>Littersize at Birth</td>
                            <td class="center">6.42 &plusmn; 1.72</td>
                        </tr>
                        <tr>
                            <td>Weaning Weight, kg</td>
                            <td class="center">4.79 &plusmn; 0.79</td>
                        </tr>
                        <tr>
                            <td>Age at Weaning, days</td>
                            <td class="center">45.21 &plusmn; 1.95</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>