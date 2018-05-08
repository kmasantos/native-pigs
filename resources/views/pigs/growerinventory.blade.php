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
					<select id="year_grower_inventory" name="year_grower_inventory" class="browser-default">
						<option disabled selected>Choose year</option>
						@foreach($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
						@endforeach
					</select>
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
		var ctx0 = document.getElementById("0").getContext('2d');
		var growerinventorychart0 = new Chart(ctx0, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Female",
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Male",
						"data":[2,1,1,4,3,0,1,4],
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