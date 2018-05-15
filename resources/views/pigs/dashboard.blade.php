@extends('layouts.swinedefault ')

@section('initScriptsAndStyles')
  <link type="text/css" rel="stylesheet" href="{{ asset('css/pig.css') }}"  media="screen,projection"/>
@endsection

@section('title')
  Dashboard
@endsection


@section('content')
  <div class="container">
    <div class="row">
      <h4>Dashboard</h4>
      <div class="divider"></div>
      <div class="row center">
        <div class="col s12 m10 l12">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>Number of Female Pigs</h5>
              <div class="row">
                <div class="col s6">
                  @if($femalebreeders != [])
                    <h2>{{ count($femalebreeders) }}</h2>
                  @else
                    <h4>No female breeders available</h4>
                  @endif
                  <p>Breeders</p>
                </div>
                <div class="col s6">
                  @if($femalegrowers != [])
                    <h2>{{ count($femalegrowers) }}</h2>
                  @else
                    <h4>No female growers available</h4>
                  @endif
                  <p>Growers</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m10 l12">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>Number of Male Pigs</h5>
              <div class="row">
                <div class="col s6">
                  @if($malebreeders != [])
                    <h2>{{ count($malebreeders) }}</h2>
                  @else
                    <h4>No male breeders available</h4>
                  @endif
                  <p>Breeders</p>
                </div>
                <div class="col s6">
                  @if($malegrowers != [])
                    <h2>{{ count($malegrowers) }}</h2>
                  @else
                    <h4>No male growers available</h4>
                  @endif
                  <p>Growers</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="col s12 m10 l4">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>Mortality</h5>
              <div class="row">
                <div class="col s12">
                  <h3>{{ count($dead) }}</h3>
                  <h6>Mortality Rate: {{ round($mortalityRate, 2) }}%</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m10 l8">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>Sales</h5>
              <div class="row">
                <div class="col s6">
                  <h3>{{ count($sold) }}</h3>
                  <h6>Sales Rate: {{ round($salesRate, 2) }}%</h6>
                </div>
                <div class="col s6">
                  @if($weights == [])
                    <h5>No data<br>available</h5>
                  @else
                    <h3>{{ round(array_sum($weights)/count($weights), 2) }}</h3>
                  @endif
                  <h6>Average weight, kg</h6>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {{-- <script type="text/javascript" src="{{asset('js/custom.js')}}"></script> --}}
@endsection
