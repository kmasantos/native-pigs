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
	</script>
@endsection