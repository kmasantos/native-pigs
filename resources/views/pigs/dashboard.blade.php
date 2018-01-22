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
                <h5>Number of Sow</h5>
                <h3>###</h3>
                <p>Month</p>
              </div>
              <div class="card-action grey darken-2">
                <a href="#!" class="red-text text-lighten-2">Prev</a>
                <a href="#!" class="red-text text-lighten-2">Next</a>
              </div>
            </div>
          </div>
          <div class="col s12 m10 l6">
            <div class="card">
              <div class="card-content grey">
              <h5>Number of Boar</h5>
              <h3>###</h3>
              <p>Month</p>
              </div>
              <div class="card-action grey darken-2">
                <a href="#!" class="red-text text-lighten-2">Prev</a>
                <a href="#!" class="red-text text-lighten-2">Next</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row center">
          <div class="col s12 m12 l8">
            <div class="card">
              <div class="card-content grey">
                <h5 class="left-align">Sales</h5>
                <div class="row center">
                  <div class="col s6 m6 l6">
                    <h3>##</h3>
                  </div>
                  <div class="col s6 m6 l6">
                    <h4>##.##</h4>
                    <p>Average Weight (kg)</p>
                  </div>
                </div>
                <p>Month</p>
              </div>
              <div class="card-action grey darken-2">
                <a href="#!" class="red-text text-lighten-2">Prev</a>
                <a href="#!" class="red-text text-lighten-2">Next</a>
              </div>
            </div>
          </div>
          <div class="col s4 m4 l4">
            <div class="card">
              <div class="card-content grey">
                <h5>Mortality</h5>
                <div class="row">
                  <div class="col s6 m6 l6">
                    <h4>#</h4>
                    <p>Sow</p>
                  </div>
                  <div class="col s6 m6 l6">
                    <h4>#</h4>
                    <p>Boar</p>
                  </div>
                </div>
                <p>Month</p>
              </div>
              <div class="card-action grey darken-2">
                <a href="#!" class="red-text text-lighten-2">Prev</a>
                <a href="#!" class="red-text text-lighten-2">Next</a>
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
