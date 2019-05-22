@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales Report
@endsection

@section('content')
	<div class="container">
		<h4>Mortality &amp; Sales Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
      <h5>Inventory for <strong>{{ Carbon\Carbon::parse($now)->format('F, Y') }}</strong> as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
			<div class="col s12 m12 l8">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Dead Pigs</h5>
            <div class="row">
              <div class="col s6">
                @if(!is_null($currentdeadpigs))
                  <h3>{{ count($currentdeadpigs) }}</h3>
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
      <div class="col s12 m12 l4">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Culled/Donated Pigs</h5>
              <h2>{{ count($currentremoved) }}</h2>
              <p>Total</p>
          </div>
        </div>
      </div>
      <div class="col s12 m12 l12">
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
                      <th>Culled/Donated</th>
                    </tr>
                    <tr>
                      <th>Number of Pigs Died</th>
                      <th>Average Age, months</th>
                      <th class="grey lighten-2">Number of Pigs Sold</th>
                      <th class="grey lighten-2">Average Age, months</th>
                      <th class="grey lighten-2">Average Weight, kg</th>
                      <th>Number of Pigs Culled/Donated</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($months as $month)
                      <tr>
                        <td class="grey lighten-2">{{ $month }}</td>
                        <td>{{ count(App\Http\Controllers\FarmController::getMonthlyMortality($year, $month)) }}</td>
                        @if(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, "dead") == [])
                          <td>No data available</td>
                        @else
                          <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, "dead"))/count(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, "dead")), 2) }}</td>
                        @endif
                        <td class="grey lighten-2">{{ count(App\Http\Controllers\FarmController::getMonthlySales($year, $month)) }}</td>
                        @if(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, "sold") == [])
                          <td class="grey lighten-2">No data available</td>
                        @else
                          <td class="grey lighten-2">{{ round(array_sum(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, "sold"))/count(App\Http\Controllers\FarmController::getMonthlyAverageAge($year, $month, "sold")), 2) }}</td>
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
    <div class="fixed-action-btn">
      <a class="btn-floating btn-large green darken-4">
        <i class="large material-icons">cloud_download</i>
      </a>
      <ul>
        <li><a class="btn-floating green lighten-1 tooltipped" data-position="left" data-tooltip="Download as CSV File"><i class="material-icons">table_chart</i></a></li>
        <li><a href="{{ URL::route('farm.pig.mortality_and_sales_download_pdf') }}" class="btn-floating green darken-1 tooltipped" data-position="left" data-tooltip="Download as PDF"><i class="material-icons">file_copy</i></a></li>
      </ul>
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
      $(document).ready(function(){
        $('.fixed-action-btn').floatingActionButton();
      });
  </script>
@endsection