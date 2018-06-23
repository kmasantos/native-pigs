@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales Report
@endsection

@section('content')
	<div class="container">
		<h4>Mortality &amp; Sales Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
      <h5>Inventory for {{ Carbon\Carbon::parse($now)->format('F, Y') }} as of {{ Carbon\Carbon::parse($now)->format('F j, Y') }}</h5>
			<div class="col s12 m10 l8">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Dead Pigs</h5>
            <div class="row">
              <div class="col s6">
                @if($dead_breeders != [] || $dead_growers != [])
                  <h3>{{ count($currentdeadbreeders) + count($currentdeadgrowers) }}</h3>
                @else
                  <h4>No data available</h4>
                @endif
                <p>Total</p>
              </div>
              <div class="col s6">
                @if($ages_dead == [])
                  <h4>No data available</h4>
                  <p>Average age, months</p>
                @else
                  <h3>{{ round(array_sum($ages_dead)/count($ages_dead), 2) }}</h3>
                  <p>Average Age, months</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l4">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Donated Pigs</h5>
              <h1>{{ count($currentremoved) }}</h1>
              <p>Total</p>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l12">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Sold Pigs</h5>
           	<div class="row">
	            <div class="col s6">
                <h4>{{ count($currentsoldbreeders) }}</h4>
	            	<p>Breeders</p>
	            </div>
	            <div class="col s6">
                <h4>{{ count($currentsoldgrowers) }}</h4>
	            	<p>Growers</p>
	            </div>
	          </div>
            <h5>Average Age when Sold, months</h5>
            <div class="row">
              <div class="col s6">
                @if($ages_currentsoldbreeder == [])
                  <h4>No data available</h4>
                  <p>Breeders</p>
                @else
                  <h4>{{ round(array_sum($ages_currentsoldbreeder)/count($ages_currentsoldbreeder), 2) }}</h4>
                  <p>Breeders</p>
                @endif
              </div>
              <div class="col s6">
               @if($ages_currentsoldgrower == [])
                  <h4>No data available</h4>
                  <p>Growers</p>
                @else
                  <h4>{{ round(array_sum($ages_currentsoldgrower)/count($ages_currentsoldgrower), 2) }}</h4>
                  <p>Growers</p>
                @endif
              </div>
            </div>
            <h5>Average Weight when Sold, kg</h5>
            <div class="row">
              <div class="col s6">
                @if($weights_currentsoldbreeder == [])
                  <h4>No data available</h4>
                  <p>Breeders</p>
                @else
                  <h4>{{ round(array_sum($weights_currentsoldbreeder)/count($weights_currentsoldbreeder), 2) }}</h4>
                  <p>Breeders</p>
                @endif
              </div>
              <div class="col s6">
                @if($weights_currentsoldgrower == [])
                  <h4>No data available</h4>
                  <p>Growers</p>
                @else
                  <h4>{{ round(array_sum($weights_currentsoldgrower)/count($weights_currentsoldgrower), 2) }}</h4>
                  <p>Growers</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
		</div>
    <div class="row center">
      <h5>Summary</h5>
      <div class="col s12">
        <ul class="collapsible popout">
          @foreach($years as $year)
            <li>
              <div class="collapsible-header grey lighten-2">{{ $year }}</div>
              <div class="collapsible-body">
                <table class="centered">
                  <thead>
                    <tr>
                      <th class="grey lighten-2" rowspan="2">Month</th>
                      <th colspan="2">Mortality</th>
                      <th colspan="3" class="grey lighten-2">Sales</th>
                      <th>Donated</th>
                    </tr>
                    <tr>
                      <th>Number of Pigs Died</th>
                      <th>Average Age, months</th>
                      <th class="grey lighten-2">Number of Pigs Sold</th>
                      <th class="grey lighten-2">Average Age, months</th>
                      <th class="grey lighten-2">Average Weight, kg</th>
                      <th>Number of Pigs Donated</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($months as $month)
                      <tr>
                        <td class="grey lighten-2">{{ $month }}</td>
                        <td>{{ count(App\Http\Controllers\FarmController::getMonthlyMortality($year, $month)) }}</td>
                        @if(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, 55) == [])
                          <td>No data available</td>
                        @else
                          <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, 55))/count(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, 55)), 2) }}</td>
                        @endif
                        <td class="grey lighten-2">{{ count(App\Http\Controllers\FarmController::getMonthlySales($year, $month)) }}</td>
                        @if(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, 56) == [])
                          <td class="grey lighten-2">No data available</td>
                        @else
                          <td class="grey lighten-2">{{ round(array_sum(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, 56))/count(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, 56)), 2) }}</td>
                        @endif
                        @if(App\Http\Controllers\FarmController::getMonthlyAverageWeightSold($year, $month) == [])
                          <td class="grey lighten-2">No data available</td>
                        @else
                          <td class="grey lighten-2">{{ round(array_sum(App\Http\Controllers\FarmController::getMonthlyAverageWeightSold($year, $month))/count(App\Http\Controllers\FarmController::getMonthlyAverageWeightSold($year, $month)), 2) }}</td>
                        @endif
                        <td>{{ count(App\Http\Controllers\FarmController::getMonthlyRemoved($year, $month)) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
	</div>
@endsection