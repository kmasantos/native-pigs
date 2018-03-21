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
        <div class="col s12 m10 l6">
          <div class="card">
            <div class="card-content grey">
              <h5>Number of Sows</h5>
              <h3>{{ $sowcount }}</h3>
            </div>
          </div>
        </div>
        <div class="col s12 m10 l6">
          <div class="card">
            <div class="card-content grey">
              <h5>Number of Boars</h5>
              <h3>{{ $boarcount }}</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row center">
        <div class="col s12 m10 l4">
          <div class="card">
            <div class="card-content grey">
              <h5>Mortality</h5>
              <div class="row">
                <div class="col s12">
                  <h3>{{ $deadcount }}</h3>
                  <h6>Mortality Rate: {{ round($mortalityRate, 2) }}%</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m10 l8">
          <div class="card">
            <div class="card-content grey">
              <h5>Sales</h5>
              <div class="row">
                <div class="col s6">
                  <h3>{{ $soldcount }}</h3>
                  <h6>Sales Rate: {{ round($salesRate, 2) }}%</h6>
                </div>
                <div class="col s6">
                  @if($weights == [])
                    <h5>No data<br>available</h5>
                  @else
                    <h3>{{ $averageWeight }}</h3>
                  @endif
                  <h6>Average weight, kg</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {{-- <script type="text/javascript" src="{{asset('js/custom.js')}}"></script> --}}
@endsection
