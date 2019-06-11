<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Native Pigs: News</title>
        <link rel="shortcut icon" href="{{asset('images/logo-swine-square.png')}}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{asset('thirdparty/materialize/css/materialize.min.css')}}"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
        <style>
            body {
                text-align: justify;
                font-size: 1.64rem;
                line-height: 110%;
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
                        <a href="{{url('/#news')}}" class="breadcrumb">News</a>
                        <a href="{{url('/news/increasing_demand_of_marinduque_native_pigs')}}" class="breadcrumb">Incresing Demand of Marinduque Native Pigs..</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row" style="padding-top: 70px;">
            <div class="col s12">
                <h4>Increasing Demand of Marinduque Native Pigs<br>An appeal to the Nucleus Farm to prepare for Possible Shortage of Supply this Year</h4>
                <h6><i>&mdash;Thon Roma, 18 February, 2019</i></h6>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <img src="{{asset('images/news1-1.png')}}" width="300" style="float: left; padding-right: 10px;">As the most requested breed in La Loma for lechon business, Marinduque Native Pigs have shown an increase in demand for several years. Surprisingly last year the number of Native Pig supply orders was recorded as on the top of the market because of its enormous increased compared from the usual quantity of pork provided in Metro Manila and other neighboring cities and provinces.<br>This year, it is expected to have a substantial increased compared to the number of swine provided for the past years considering that in Marinduque, native pigs are the most recommended breed for lechon processing, and other meat-related markets. Some of the business operators said that if the number of pigs will not multiply this year, it will be difficult to meet possible demand in supply of pigs for the business sectors in the local community and to the lechoneros in La Loma.<br>The Native Pig Nucleus Farm in Poctoy Torrijos Marinduque as the biggest and famous production site in the province already built a Native Pig Insemination Laboratory that will enhance the production of native pigs using Artificial Insemination, and it is planned to open this year.<br><img src="{{asset('images/news1-3.png')}}">
            </div>
            <div class="col s6">
                Dr. Arnolfo Monleon as program leader of this Project since July 2014 in Partnership with DOST-PCAARRD continually working out in providing orientation and trainings for local Farm operators in the community as part of the merging process with private farm owners. It is to enhance the ability of every Marinduqueno farmer in producing quality Native Pigs that will meet the increasing demand in the local market and in the business areas of lechoneros.<br>On their extension activity intended to all Co-operators in the province entitled “<i>Promotion of Sustainable Native Pig Production</i>” the team began to meet the local Native pig farmers last December 2018 in secluded areas of nearby Barangays of Poctoy. As part of the program they distributed six refined Boars to selected Co-operators, <i>Mr. Rolando Postrado</i> of Tigwi, <i>Mr. Bedincio Linga</i> and <i>Alicia Regalado</i> of Sibuyao, <i>Mr. Leon Perin</i> of Bangwayin, <i>Remegio Rioflorido</i> of Pakaskasan and <i>Roger Quinto</i> of Marlangga Torrijos.<img src="{{asset('images/news1-2.png')}}" width="350" style="float: left; padding-right: 10px;"> This activity aims to provide good performing boars that will possibly increase the litter size of sows owned by the farmers.They had agreed that every time the sow delivers piglets oneshould be distributed to another family who wants to start raising pigs and be part of the farmers’ society. It is assumed that this year, the on-going project will continue to improve the number of Native pigs in the whole province.<br><img src="{{asset('images/news1-4.png')}}" width="550">
            </div>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>