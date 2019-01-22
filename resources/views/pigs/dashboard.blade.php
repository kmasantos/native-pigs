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
        <h5>Inventory as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
        <div class="col s12 m10 l12">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>Number of Female Pigs</h5>
              <div class="row">
                <div class="col s6">
                  @if($femalebreeders != [])
                    <div class="col s6">
                      <h3>{{ count($sows) }}</h3>
                      <p>Sows</p>
                    </div>
                    <div class="col s6">
                      <h3>{{ count($gilts) }}</h3>
                      <p>Gilts</p>
                    </div>
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
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false, // Close upon selecting a date,
        format: 'yyyy-mm-dd', 
        max: new Date()
      });
  </script>
@endsection