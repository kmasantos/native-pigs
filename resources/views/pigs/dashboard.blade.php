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
      <div class="row center">
        <canvas id="monthlyperformancecanvas"></canvas>
      </div>
      <div class="row center">
        <canvas id="monthlyborncanvas"></canvas>
      </div>
      <div class="row center">
        <canvas id="monthlyweanedcanvas"></canvas>
      </div>
      <div class="row center">
        <canvas id="monthlyaverageweightscanvas"></canvas>
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
    var monthlybred = {
      label: 'Monthly Bred',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyBred($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(255, 99, 132)',
      backgroundColor: 'transparent'
    };
    var monthlyfarrowed = {
      label: 'Monthly Farrowed',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyFarrowed($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(54, 162, 235)',
      backgroundColor: 'transparent'
    };
    var monthlyweaned = {
      label: 'Monthly Weaned',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyWeaned($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(255, 206, 86)',
      backgroundColor: 'transparent'
    };
    var monthlydata = {
      labels: [@foreach($months as $month) "{{ $month }}", @endforeach],
      datasets: [monthlybred, monthlyfarrowed, monthlyweaned]
    };
    var chartOptions = {
      responsive: true,
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Months'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Count'
          }
        }],
        elements: {
          line: {
            fill: false
          }
        }
      }
    };
    var ctx1 = document.getElementById("monthlyperformancecanvas").getContext('2d');
    var monthlyperformancechart = new Chart(ctx1, {
      type: 'line',
      data: monthlydata,
      options: chartOptions
    });
    var monthlylsba = {
      label: 'Total Born Alive',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyLSBA($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(255, 99, 132)',
      backgroundColor: 'transparent'
    };
    var monthlynumbermales = {
      label: 'Number of Males',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyNumberMales($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(54, 162, 235)',
      backgroundColor: 'transparent'
    };
    var monthlynumberfemales = {
      label: 'Number of Females',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyNumberFemales($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(255, 206, 86)',
      backgroundColor: 'transparent'
    };
    var monthlyaverageborn = {
      label: 'Average Born Alive',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyAverageBorn($filter, $month) }}, @endforeach,
      ],
      borderColor: 'rgb(75, 192, 192)',
      backgroundColor: 'transparent',
      borderDash: [5,5]
    };
    var monthlyinventoryborn = {
      labels: [@foreach($months as $month) "{{ $month }}", @endforeach],
      datasets: [monthlylsba, monthlynumbermales, monthlynumberfemales, monthlyaverageborn]
    };
    var chartOptions2 = {
      responsive: true,
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Months'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Count'
          }
        }],
        elements: {
          line: {
            fill: false
          }
        }
      }
    };
    var ctx2 = document.getElementById("monthlyborncanvas").getContext('2d');
    var monthlybornchart = new Chart(ctx2, {
      type: 'line',
      data: monthlyinventoryborn,
      options: chartOptions2
    });
    var monthlynumberweaned = {
      label: 'Total Littersize Weaned',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyNumberWeaned($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(255, 99, 132)',
      backgroundColor: 'transparent'
    };
    var monthlyaverageweaned = {
      label: 'Average Weaned',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyAverageWeaned($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(54, 162, 235)',
      backgroundColor: 'transparent',
      borderDash: [5,5]
    };
    var monthlyinventoryweaned = {
      labels: [@foreach($months as $month) "{{ $month }}", @endforeach],
      datasets: [monthlynumberweaned, monthlyaverageweaned]
    };
    var chartOptions3 = {
      responsive: true,
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Months'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Count'
          }
        }],
        elements: {
          line: {
            fill: false
          }
        }
      }
    };
    var ctx3 = document.getElementById("monthlyweanedcanvas").getContext('2d');
    var monthlyweanedchart = new Chart(ctx3, {
      type: 'line',
      data: monthlyinventoryweaned,
      options: chartOptions3
    });
    var monthlyaveragebirthweight = {
      label: 'Average Birth Weight',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyAverageBirthWeight($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(255, 99, 132)',
      backgroundColor: 'transparent',
      borderDash: [5,5]
    };
    var monthlyaverageweaningweight = {
      label: 'Average Weaning Weight',
      data: [
        @foreach($months as $month) {{ App\Http\Controllers\FarmController::getMonthlyAverageWeaningWeight($filter, $month) }}, @endforeach, 
      ],
      borderColor: 'rgb(54, 162, 235)',
      backgroundColor: 'transparent',
      borderDash: [5,5]
    };
    var monthlyaverageweights = {
      labels: [@foreach($months as $month) "{{ $month }}", @endforeach],
      datasets: [monthlyaveragebirthweight, monthlyaverageweaningweight]
    };
    var chartOptions4 = {
      responsive: true,
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Months'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Value'
          }
        }],
        elements: {
          line: {
            fill: false
          }
        }
      }
    };
    var ctx4 = document.getElementById("monthlyaverageweightscanvas").getContext('2d');
    var monthlyaverageweightschart = new Chart(ctx4, {
      type: 'line',
      data: monthlyaverageweights,
      options: chartOptions4
    });
  </script>
@endsection