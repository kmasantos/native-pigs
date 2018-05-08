@extends('layouts.farm')

@section('title')
	Native Animals PH | Duck Family Records
@endsection

@section('initScript')
	<link type="text/css" rel="stylesheet" href="{{asset('css/record.css')}}"  media="screen,projection"/>
@endsection

@section('content')
	<div class="row">
		<div class="col s12 m12 l12 xl12">
			<h4>Family Record</h4>
			<div class="row">
				<div class="col s12 m12 l12">
					<div class="row">
						<div class="col s12 m12 l12">
							<ul class="collapsible" data-collapsible="accordion">
								<li>
									<div class="collapsible-header"><h5>Family #</h5></div>
									<div class="collapsible-body">
											<ul class="collection">
												<li class="collection-item">Generation</li>
												<li class="collection-item">Pen No.</li>
												<li class="collection-item">Drakes ID No.</li>
												<li class="collection-item">Ducks ID No.</li>
												<li class="collection-item">Birthdate</li>
											</ul>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12">
					<ul class="tabs">
						<li class="tab col s4"><a href="#eggproduction">Egg Production</a></li>
						<li class="tab col s4"><a href="#eggquality">Egg Quality</a></li>
						<li class="tab col s4"><a href="#feedconsumption">Feeding Consumption</a></li>
					</ul>
				</div>
				
				<div id="eggproduction" class="col s12">
					<div class="row">
						<div class="col s12 m12 l12">
							<div class="row">
								<div class="col s12 m12 l12">
									<div class="row">
										<div class="col s12 m12 l12">
											<h4>Weekly Data</h4>
										</div>
									</div>
									<div class="row">
										<div class="col s12 m12 l12">
											<table class="responsive-table bordered">
												<thead>
													<tr>
														<th>Week 1</th>
														<th>Week 2</th>
														<th>Week 1</th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td>10</td>
														<td>5</td>
														<td>3</td>
													</tr>
													<tr>
														<td>4</td>
														<td>8</td>
														<td>12</td>
													</tr>
													<tr>
														<td>10</td>
														<td>11</td>
														<td>2</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="eggquality" class="col s12">
					<table class="responsive-table bordered">
						<thead>
							<tr>
								<th>Sample</th>
								<th>Egg Weight</th>
								<th>Egg Color</th>
								<th>Egg Shape</th>
								<th>Length</th>
								<th>Width</th>
								<th>Shell Weight</th>
								<th>Top</th>
								<th>Middle</th>
								<th>Bottom</th>
								<th>Albumen Height</th>
								<th>Yolk Color</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>1</td>
								<td>2</td>
								<td>3</td>
							</tr>
							
						</tbody>
					</table>
				</div>
				<div id="feedconsumption" class="col s12">
					<table class="responsive-table bordered">
						<thead>
							<tr>
								<th>Feed Offered</th>
								<th>Feed Refused</th>
								<th>Average</th>
								<th>Mortality</th>
								<th>Culled</th>
								<th>Remarks</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>1</td>
								<td>2</td>
								<td>3</td>
							</tr>
							
						</tbody>
					</table>

				</div>
				
			</div>
		</div>
	</div>
@endsection