@extends('layouts.swinedefault')

@section('title')
	Grower Inventory Report
@endsection

@section('content')
	<div class="container">
		<h4>Grower Inventory Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<canvas id="growerinventorycanvas"></canvas>
			<h5>Age, months</h5>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var ctx1 = document.getElementById("growerinventorycanvas").getContext('2d');
		var growerinventorychart = new Chart(ctx1, {
			"type":"bar",
			"data": {
				"labels":["0","1","2","3","4","5","6", ">6"],
				"datasets":[
					{
						"label":"Sows",
						"data":[2,3,4,5,1,3,6,1],
						"fill":false,
						"backgroundColor": "rgba(255, 99, 132, 0.2)",
						"borderColor": "rgb(255, 99, 132)",
						"borderWidth":1
					},
					{
						"label": "Boars",
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