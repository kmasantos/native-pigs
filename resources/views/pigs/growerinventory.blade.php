@extends('layouts.swinedefault')

@section('title')
	Grower Inventory Report
@endsection

@section('content')
	<div class="container">
		<h4>Grower Inventory Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="row center">
				<div id="year_grower_inventory" class="col s4 offset-s4">
					{!! Form::open(['route' => 'farm.pig.filter_grower_inventory', 'method' => 'post', 'id' => 'inventory_filter']) !!}
					<select id="year_grower_inventory" name="year_grower_inventory" class="browser-default" onchange="document.getElementById('inventory_filter').submit();">
						<option disabled selected>Year ({{ $filter }})</option>
						@foreach($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
						@endforeach
					</select>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="row">
				@foreach($months as $month)
					<div class="col s12 m10 l6">
		        <div class="card">
		          <div class="card-content grey lighten-2">
		          	<h5>{{ $month }}</h5>
		            <canvas id="{{ $index++ }}"></canvas>
								<p>Age, months</p>
		          </div>
		        </div>
		      </div>
		    @endforeach
		  </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
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
		var ctx0 = document.getElementById("0").getContext('2d');
		var growerinventorychart0 = new Chart(ctx0, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[0][0] }}, {{ $monthlysows[0][1] }}, {{ $monthlysows[0][2] }}, {{ $monthlysows[0][3] }}, {{ $monthlysows[0][4] }}, {{ $monthlysows[0][5] }}, {{ $monthlysows[0][6] }}, {{ $monthlysows[0][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[0][0] }}, {{ $monthlyboars[0][1] }}, {{ $monthlyboars[0][2] }}, {{ $monthlyboars[0][3] }}, {{ $monthlyboars[0][4] }}, {{ $monthlyboars[0][5] }}, {{ $monthlyboars[0][6] }}, {{ $monthlyboars[0][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx1 = document.getElementById("1").getContext('2d');
		var growerinventorychart1 = new Chart(ctx1, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[1][0] }}, {{ $monthlysows[1][1] }}, {{ $monthlysows[1][2] }}, {{ $monthlysows[1][3] }}, {{ $monthlysows[1][4] }}, {{ $monthlysows[1][5] }}, {{ $monthlysows[1][6] }}, {{ $monthlysows[1][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[1][0] }}, {{ $monthlyboars[1][1] }}, {{ $monthlyboars[1][2] }}, {{ $monthlyboars[1][3] }}, {{ $monthlyboars[1][4] }}, {{ $monthlyboars[1][5] }}, {{ $monthlyboars[1][6] }}, {{ $monthlyboars[1][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx2 = document.getElementById("2").getContext('2d');
		var growerinventorychart2 = new Chart(ctx2, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[2][0] }}, {{ $monthlysows[2][1] }}, {{ $monthlysows[2][2] }}, {{ $monthlysows[2][3] }}, {{ $monthlysows[2][4] }}, {{ $monthlysows[2][5] }}, {{ $monthlysows[2][6] }}, {{ $monthlysows[2][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[2][0] }}, {{ $monthlyboars[2][1] }}, {{ $monthlyboars[2][2] }}, {{ $monthlyboars[2][3] }}, {{ $monthlyboars[2][4] }}, {{ $monthlyboars[2][5] }}, {{ $monthlyboars[2][6] }}, {{ $monthlyboars[2][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx3 = document.getElementById("3").getContext('2d');
		var growerinventorychart3 = new Chart(ctx3, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[3][0] }}, {{ $monthlysows[3][1] }}, {{ $monthlysows[3][2] }}, {{ $monthlysows[3][3] }}, {{ $monthlysows[3][4] }}, {{ $monthlysows[3][5] }}, {{ $monthlysows[3][6] }}, {{ $monthlysows[3][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[3][0] }}, {{ $monthlyboars[3][1] }}, {{ $monthlyboars[3][2] }}, {{ $monthlyboars[3][3] }}, {{ $monthlyboars[3][4] }}, {{ $monthlyboars[3][5] }}, {{ $monthlyboars[3][6] }}, {{ $monthlyboars[3][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx4 = document.getElementById("4").getContext('2d');
		var growerinventorychart4 = new Chart(ctx4, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[4][0] }}, {{ $monthlysows[4][1] }}, {{ $monthlysows[4][2] }}, {{ $monthlysows[4][3] }}, {{ $monthlysows[4][4] }}, {{ $monthlysows[4][5] }}, {{ $monthlysows[4][6] }}, {{ $monthlysows[4][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[4][0] }}, {{ $monthlyboars[4][1] }}, {{ $monthlyboars[4][2] }}, {{ $monthlyboars[4][3] }}, {{ $monthlyboars[4][4] }}, {{ $monthlyboars[4][5] }}, {{ $monthlyboars[4][6] }}, {{ $monthlyboars[4][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx5 = document.getElementById("5").getContext('2d');
		var growerinventorychart5 = new Chart(ctx5, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[5][0] }}, {{ $monthlysows[5][1] }}, {{ $monthlysows[5][2] }}, {{ $monthlysows[5][3] }}, {{ $monthlysows[5][4] }}, {{ $monthlysows[5][5] }}, {{ $monthlysows[5][6] }}, {{ $monthlysows[5][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[5][0] }}, {{ $monthlyboars[5][1] }}, {{ $monthlyboars[5][2] }}, {{ $monthlyboars[5][3] }}, {{ $monthlyboars[5][4] }}, {{ $monthlyboars[5][5] }}, {{ $monthlyboars[5][6] }}, {{ $monthlyboars[5][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx6 = document.getElementById("6").getContext('2d');
		var growerinventorychart6 = new Chart(ctx6, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[6][0] }}, {{ $monthlysows[6][1] }}, {{ $monthlysows[6][2] }}, {{ $monthlysows[6][3] }}, {{ $monthlysows[6][4] }}, {{ $monthlysows[6][5] }}, {{ $monthlysows[6][6] }}, {{ $monthlysows[6][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[6][0] }}, {{ $monthlyboars[6][1] }}, {{ $monthlyboars[6][2] }}, {{ $monthlyboars[6][3] }}, {{ $monthlyboars[6][4] }}, {{ $monthlyboars[6][5] }}, {{ $monthlyboars[6][6] }}, {{ $monthlyboars[6][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx7 = document.getElementById("7").getContext('2d');
		var growerinventorychart7 = new Chart(ctx7, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[7][0] }}, {{ $monthlysows[7][1] }}, {{ $monthlysows[7][2] }}, {{ $monthlysows[7][3] }}, {{ $monthlysows[7][4] }}, {{ $monthlysows[7][5] }}, {{ $monthlysows[7][6] }}, {{ $monthlysows[7][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[7][0] }}, {{ $monthlyboars[7][1] }}, {{ $monthlyboars[7][2] }}, {{ $monthlyboars[7][3] }}, {{ $monthlyboars[7][4] }}, {{ $monthlyboars[7][5] }}, {{ $monthlyboars[7][6] }}, {{ $monthlyboars[7][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx8 = document.getElementById("8").getContext('2d');
		var growerinventorychart8 = new Chart(ctx8, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[8][0] }}, {{ $monthlysows[8][1] }}, {{ $monthlysows[8][2] }}, {{ $monthlysows[8][3] }}, {{ $monthlysows[8][4] }}, {{ $monthlysows[8][5] }}, {{ $monthlysows[8][6] }}, {{ $monthlysows[8][7] }}],
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[8][0] }}, {{ $monthlyboars[8][1] }}, {{ $monthlyboars[8][2] }}, {{ $monthlyboars[8][3] }}, {{ $monthlyboars[8][4] }}, {{ $monthlyboars[8][5] }}, {{ $monthlyboars[8][6] }}, {{ $monthlyboars[8][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx9 = document.getElementById("9").getContext('2d');
		var growerinventorychart9 = new Chart(ctx9, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[9][0] }}, {{ $monthlysows[9][1] }}, {{ $monthlysows[9][2] }}, {{ $monthlysows[9][3] }}, {{ $monthlysows[9][4] }}, {{ $monthlysows[9][5] }}, {{ $monthlysows[9][6] }}, {{ $monthlysows[9][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[9][0] }}, {{ $monthlyboars[9][1] }}, {{ $monthlyboars[9][2] }}, {{ $monthlyboars[9][3] }}, {{ $monthlyboars[9][4] }}, {{ $monthlyboars[9][5] }}, {{ $monthlyboars[9][6] }}, {{ $monthlyboars[9][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx10 = document.getElementById("10").getContext('2d');
		var growerinventorychart10 = new Chart(ctx10, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[10][0] }}, {{ $monthlysows[10][1] }}, {{ $monthlysows[10][2] }}, {{ $monthlysows[10][3] }}, {{ $monthlysows[10][4] }}, {{ $monthlysows[10][5] }}, {{ $monthlysows[10][6] }}, {{ $monthlysows[10][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[10][0] }}, {{ $monthlyboars[10][1] }}, {{ $monthlyboars[10][2] }}, {{ $monthlyboars[10][3] }}, {{ $monthlyboars[10][4] }}, {{ $monthlyboars[10][5] }}, {{ $monthlyboars[10][6] }}, {{ $monthlyboars[10][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
		var ctx11 = document.getElementById("11").getContext('2d');
		var growerinventorychart11 = new Chart(ctx11, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[{{ $monthlysows[11][0] }}, {{ $monthlysows[11][1] }}, {{ $monthlysows[11][2] }}, {{ $monthlysows[11][3] }}, {{ $monthlysows[11][4] }}, {{ $monthlysows[11][5] }}, {{ $monthlysows[11][6] }}, {{ $monthlysows[11][7] }}],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[{{ $monthlyboars[11][0] }}, {{ $monthlyboars[11][1] }}, {{ $monthlyboars[11][2] }}, {{ $monthlyboars[11][3] }}, {{ $monthlyboars[11][4] }}, {{ $monthlyboars[11][5] }}, {{ $monthlyboars[11][6] }}, {{ $monthlyboars[11][7] }}],
						"fill":false,
						"backgroundColor": "rgba(75, 192, 192, 0.2)",
						"borderColor": "rgb(75, 192, 192)",
						"borderWidth":1
					}
				],
			},
			"options":{
				"scales":{
					"yAxes":[{
						"ticks":{
							"beginAtZero":true
						}
					}]
				}
			}
		});
	</script>
@endsection