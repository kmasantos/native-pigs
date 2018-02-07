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
    </div>
  </div>
@endsection

@section('scripts')
  {{-- <script type="text/javascript" src="{{asset('js/custom.js')}}"></script> --}}
@endsection
