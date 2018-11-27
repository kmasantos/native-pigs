@extends('layouts.swinedefault')

@section('title')
  Monthly Performance Report
@endsection


@section('content')
  <div class="container">
    <h4>Monthly Performance Report</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
    	<div class="row center">
				<div id="year_monthly_performance" class="col s4 offset-s4">
					{!! Form::open(['route' => 'farm.pig.filter_monthly_performance', 'method' => 'post', 'id' => 'monthly_performance_filter']) !!}
					<select id="year_monthly_performance" name="year_monthly_performance" class="browser-default" onchange="document.getElementById('monthly_performance_filter').submit();">
						<option disabled selected>Year ({{ $filter }})</option>
						@foreach($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
						@endforeach
					</select>
					{!! Form::close() !!}
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
	<script>
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
      label: 'LSBA',
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
      label: 'Number Weaned',
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