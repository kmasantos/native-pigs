@extends('layouts.swinedefault')

@section('title')
	Production Performance Report
@endsection

@section('content')
	<div class="container">
		<h4>Production Performance Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12">
	      <ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#persowview">Per sow</a></li>
	        <li class="tab"><a href="#perboarview">Per boar</a></li>
	        <li class="tab"><a id="per_parity" href="#perparityview">Per parity</a></li>
	        <li class="tab"><a href="#permonthview">Per month</a></li>
	        <li class="tab"><a href="#perbreedview">Per breed</a></li>
	      </ul>
	    </div>
	    <!-- PER SOW -->
	    <div id="persowview" class="col s12">	    	
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Registration ID</th>
	    				<th class="center">View Production Performance</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@forelse($sowbreeders as $sowbreeder)
		    			<tr>
		    				<td>{{ $sowbreeder->registryid }}</td>
		    				<td class="center"><a href="{{ URL::route('farm.pig.sow_production_performance', [$sowbreeder->id]) }}"><i class="material-icons">visibility</i></a></td>
		    			</tr>
		    		@empty
	    				<tr>
	    					<td colspan="2" class="center">No sow data available</td>
	    				</tr>
    				@endforelse
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BOAR -->
	    <div id="perboarview" class="col s12">
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Registration ID</th>
	    				<th class="center">View Production Performance</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@forelse($boarbreeders as $boarbreeder)
		    			<tr>
		    				<td>{{ $boarbreeder->registryid }}</td>
		    				<td class="center"><a href="{{ URL::route('farm.pig.boar_production_performance', [$boarbreeder->id]) }}"><i class="material-icons">visibility</i></a></td>
		    			</tr>
		    		@empty
	    				<tr>
	    					<td colspan="2" class="center">No boar data available</td>
	    				</tr>
    				@endforelse
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER PARITY -->
	    <div id="perparityview" class="col s12">
	    	<div class="row"">
	    		<div class="col s12">
			      <ul class="tabs smalltabs">
			        <li class="tab col s2 offset-s4"><a href="#tableview"><i class="material-icons">border_all</i></a></li>
			        <li class="tab col s2"><a href="#chartview"><i class="material-icons">pie_chart</i></a></li>
			      </ul>
			    </div>
			  </div>
			  <div id="tableview" class="col s12">
				  <div class="row">
			    	<div class="col s4 offset-s1">
			  			<p>Generate Reports by:</p>
			  		</div>
		    		<div class="col s5">
		    			{!! Form::open(['route' => 'farm.pig.prod_performance_parity', 'method' => 'post', 'id' => 'report_filter']) !!}
							<select id="filter_parity" name="filter_parity" class="browser-default" onchange="document.getElementById('report_filter').submit();">
								<option disabled selected>Parity {{ $filter }}</option>
								@foreach($parity as $parity_num)
									<option value="{{ $parity_num }}">Parity {{ $parity_num }}</option>
								@endforeach
							</select>
							{!! Form::close() !!}
						</div>
		    	</div>
		    	<div class="row">
			    	<table>
			    		<thead>
			    			<tr>
			    				<th>Parameters (Averages)</th>
			    				<th class="center">Value</th>
			    				<th class="center">Standard Deviation</th>
			    			</tr>
			    		</thead>
			    		<tbody>
			    			<tr>
			    				<td>Litter-size Born Alive</td>
			    				@if($lsba == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($lsba)/count($lsba), 2) }}</td>
										<td class="center">{{ round($lsba_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Male Born</td>
			    				@if($totalmales == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($totalmales)/count($totalmales), 2) }}</td>
										<td class="center">{{ round($totalmales_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Female Born</td>
			    				@if($totalfemales == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($totalfemales)/count($totalfemales), 2) }}</td>
										<td class="center">{{ round($totalfemales_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Stillborn</td>
			    				@if($stillborn == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
										<td class="center">{{ round($stillborn_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Mummified</td>
			    				@if($mummified == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
										<td class="center">{{ round($mummified_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Litter Birth Weight, kg</td>
			    				@if($totallitterbirthweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($totallitterbirthweights)/count($totallitterbirthweights), 2) }}</td>
										<td class="center">{{ round($totallitterbirthweights_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Average Birth Weight, kg</td>
			    				@if($avelitterbirthweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($avelitterbirthweights)/count($avelitterbirthweights), 2) }}</td>
										<td class="center">{{ round($avelitterbirthweights_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Litter Weaning Weight, kg</td>
			    				@if($totallitterweaningweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($totallitterweaningweights)/count($totallitterweaningweights), 2) }}</td>
										<td class="center">{{ round($totallitterweaningweights_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Average Weaning Weight, kg</td>
			    				@if($avelitterweaningweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($avelitterweaningweights)/count($avelitterweaningweights), 2) }}</td>
										<td class="center">{{ round($avelitterweaningweights_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Adjusted Weaning Weight at 45 Days, kg</td>
			    				@if($aveadjweaningweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($aveadjweaningweights)/count($aveadjweaningweights), 2) }}</td>
										<td class="center">{{ round($aveadjweaningweights_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Weaned</td>
			    				@if($totalweaned == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($totalweaned)/count($totalweaned), 2) }}</td>
										<td class="center">{{ round($totalweaned_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Age Weaned, months</td>
			    				@if($totalagesweaned == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($totalagesweaned)/count($totalagesweaned), 2) }}</td>
										<td class="center">{{ round($totalagesweaned_sd, 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Pre-weaning Mortality</td>
			    				@if($preweaningmortality == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
										<td class="center">{{ round($preweaningmortality_sd, 2) }}</td>
									@endif
			    			</tr>
			    		</tbody>
			    	</table>
			    </div>
			  </div>
			  <div id="chartview" class="col s12">
			    <div class="row">
			    	<div class="col s12">
			    		<h5>Graphs per Parameter</h5>
			    		<div class="row">
			    			<div class="col s6 offset-s3">
			    				<p>Litter-size Born Alive</p>
					    		<canvas id="lsbacanvas"></canvas>
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col s6">
			    				<p>Number of Male Born</p>
					    		<canvas id="nummaleborncanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Number of Female Born</p>
					    		<canvas id="numfemaleborncanvas"></canvas>
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col s6">
			    				<p>Number Stillborn</p>
					    		<canvas id="numstillborncanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Number Mummified</p>
					    		<canvas id="nummummifiedcanvas"></canvas>
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col s6">
			    				<p>Litter Birth Weight, kg</p>
					    		<canvas id="bweightcanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Average Birth Weight, kg</p>
					    		<canvas id="avebweightcanvas"></canvas>
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col s6">
			    				<p>Litter Weaning Weight, kg</p>
					    		<canvas id="wweightcanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Average Weaning Weight, kg</p>
					    		<canvas id="avewweightcanvas"></canvas>
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col s6">
			    				<p>Adjusted Weaning Weight at 45 Days, kg</p>
					    		<canvas id="adjwweightcanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Number Weaned</p>
					    		<canvas id="numweanedcanvas"></canvas>
			    			</div>
			    		</div>
			    		<div class="row">
			    			<div class="col s6">
			    				<p>Age Weaned, months</p>
					    		<canvas id="ageweanedcanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Pre-weaning Mortality</p>
					    		<canvas id="preweaningmortalitycanvas"></canvas>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			  </div>
	    </div>
	    <!-- PER MONTH -->
	    <div id="permonthview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports for:</p>
		  		</div>
		  		<div class="col s5"> 
		  		{!! Form::open(['route' => 'farm.pig.prod_performance_month', 'method' => 'post', 'id' => 'report_filter2']) !!}
	    			<select id="filter_yearandmonth" name="filter_yearandmonth" class="browser-default" onchange="document.getElementById('year_filter').submit();">
							<option disabled selected>Year ({{ $filter_year }})</option>
							@foreach($years as $year)
								<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select>
	    		{!! Form::close() !!}
	    		</div>
	    	</div>
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Parameters (Averages)</th>
	    				<th class="center">Value</th>
	    				<th class="center">Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			{{-- TO BE CHANGED --}}
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				@if($lsba == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($lsba)/count($lsba), 2) }}</td>
								<td class="center">{{ round($lsba_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				@if($totalmales == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalmales)/count($totalmales), 2) }}</td>
								<td class="center">{{ round($totalmales_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				@if($totalfemales == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalfemales)/count($totalfemales), 2) }}</td>
								<td class="center">{{ round($totalfemales_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				@if($stillborn == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
								<td class="center">{{ round($stillborn_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				@if($mummified == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
								<td class="center">{{ round($mummified_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight, kg</td>
	    				@if($totallitterbirthweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totallitterbirthweights)/count($totallitterbirthweights), 2) }}</td>
								<td class="center">{{ round($totallitterbirthweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight, kg</td>
	    				@if($avelitterbirthweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($avelitterbirthweights)/count($avelitterbirthweights), 2) }}</td>
								<td class="center">{{ round($avelitterbirthweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight, kg</td>
	    				@if($totallitterweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totallitterweaningweights)/count($totallitterweaningweights), 2) }}</td>
								<td class="center">{{ round($totallitterweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight, kg</td>
	    				@if($avelitterweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($avelitterweaningweights)/count($avelitterweaningweights), 2) }}</td>
								<td class="center">{{ round($avelitterweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	    				@if($aveadjweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($aveadjweaningweights)/count($aveadjweaningweights), 2) }}</td>
								<td class="center">{{ round($aveadjweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				@if($totalweaned == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalweaned)/count($totalweaned), 2) }}</td>
								<td class="center">{{ round($totalweaned_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Age Weaned, months</td>
	    				@if($totalagesweaned == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalagesweaned)/count($totalagesweaned), 2) }}</td>
								<td class="center">{{ round($totalagesweaned_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				@if($preweaningmortality == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
								<td class="center">{{ round($preweaningmortality_sd, 2) }}</td>
							@endif
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BREED -->
	    <div id="perbreedview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Year-end Report for the year</p>
		  		</div>
	  			<div class="col s5"> 
		  		{{-- {!! Form::open(['route' => 'farm.pig.prod_performance_month', 'method' => 'post', 'id' => 'report_filter2']) !!} --}}
	    			<select id="filter_yearandmonth" name="filter_yearandmonth" class="browser-default" onchange="document.getElementById('year_filter').submit();">
							<option disabled selected>Year ({{ $filter_year }})</option>
							@foreach($years as $year)
								<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select>
	    		{{-- {!! Form::close() !!} --}}
	    		</div
>		  	</div>
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Parameters (Averages)</th>
	    				<th class="center">Value</th>
	    				<th class="center">Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			{{-- TO BE CHANGED --}}
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				@if($lsba == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($lsba)/count($lsba), 2) }}</td>
								<td class="center">{{ round($lsba_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				@if($totalmales == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalmales)/count($totalmales), 2) }}</td>
								<td class="center">{{ round($totalmales_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				@if($totalfemales == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalfemales)/count($totalfemales), 2) }}</td>
								<td class="center">{{ round($totalfemales_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				@if($stillborn == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
								<td class="center">{{ round($stillborn_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				@if($mummified == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
								<td class="center">{{ round($mummified_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight, kg</td>
	    				@if($totallitterbirthweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totallitterbirthweights)/count($totallitterbirthweights), 2) }}</td>
								<td class="center">{{ round($totallitterbirthweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight, kg</td>
	    				@if($avelitterbirthweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($avelitterbirthweights)/count($avelitterbirthweights), 2) }}</td>
								<td class="center">{{ round($avelitterbirthweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight, kg</td>
	    				@if($totallitterweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totallitterweaningweights)/count($totallitterweaningweights), 2) }}</td>
								<td class="center">{{ round($totallitterweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight, kg</td>
	    				@if($avelitterweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($avelitterweaningweights)/count($avelitterweaningweights), 2) }}</td>
								<td class="center">{{ round($avelitterweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	    				@if($aveadjweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($aveadjweaningweights)/count($aveadjweaningweights), 2) }}</td>
								<td class="center">{{ round($aveadjweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				@if($totalweaned == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalweaned)/count($totalweaned), 2) }}</td>
								<td class="center">{{ round($totalweaned_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Age Weaned, months</td>
	    				@if($totalagesweaned == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalagesweaned)/count($totalagesweaned), 2) }}</td>
								<td class="center">{{ round($totalagesweaned_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				@if($preweaningmortality == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
								<td class="center">{{ round($preweaningmortality_sd, 2) }}</td>
							@endif
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
		  $("#filter_parity").change(function () {
				event.preventDefault();
				var filter = $(this).val();
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: '../farm/production_performance_per_parity/'+filter,
					type: 'POST',
					cache: false,
					data: {filter},
					success: function(data)
					{
						Materialize.toast('Showing data with parity '+filter, 4000);
					}
				});
		  });
		});
		var ctx1 = document.getElementById("lsbacanvas").getContext('2d');
		var lsbachart = new Chart(ctx1, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Litter-size Born Alive',
          data: [3,5.4,6.27,3,8.25,5.5],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx2 = document.getElementById("nummaleborncanvas").getContext('2d');
		var nummalechart = new Chart(ctx2, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Number of Male Born',
          data: [1.31,2.45,2.91,1.13,5.5,3],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx3 = document.getElementById("numfemaleborncanvas").getContext('2d');
		var numfemalechart = new Chart(ctx3, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Number of Female Born',
          data: [1.69,2.95,3.36,1.88,2.75,2.5],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx4 = document.getElementById("numstillborncanvas").getContext('2d');
		var numstillbornchart = new Chart(ctx4, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Number of Stillborn',
          data: [0,0.04,0.31,0.2,0.5,0],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx5 = document.getElementById("nummummifiedcanvas").getContext('2d');
		var nummummifiedchart = new Chart(ctx5, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Number of Mummified',
          data: [0.05,0.3,0,0,0,1.5],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx6 = document.getElementById("bweightcanvas").getContext('2d');
		var bweightchart = new Chart(ctx6, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Litter Birth Weight',
          data: [2.48,5.06,4.97,2.74,5.17,4.09],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx7 = document.getElementById("avebweightcanvas").getContext('2d');
		var avebweightchart = new Chart(ctx7, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Average Birth Weight',
          data: [0.82,0.77,0.83,0.73,0.6,0.72],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx8 = document.getElementById("wweightcanvas").getContext('2d');
		var wweightchart = new Chart(ctx8, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Litter Weaning Weight',
          data: [23.04,38.33,44,42.5,43.53,29],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx9 = document.getElementById("avewweightcanvas").getContext('2d');
		var avewweightchart = new Chart(ctx9, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Average Weaning Weight',
          data: [5.04,5.4,5.19,5.25,8.15,4.14],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx10 = document.getElementById("adjwweightcanvas").getContext('2d');
		var adjwweightchart = new Chart(ctx10, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Adjusted Weaning Weight at 45 Days',
          data: [5.32,5.4,5.19,5.25,8.15,4.14],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx11 = document.getElementById("numweanedcanvas").getContext('2d');
		var numweanedchart = new Chart(ctx11, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Number Weaned',
          data: [4.6,8.1,8.33,8.5,6,7],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx12 = document.getElementById("ageweanedcanvas").getContext('2d');
		var ageweanedcanvas = new Chart(ctx12, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Age Weaned',
          data: [1,1,1,1,1,1],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
		var ctx13 = document.getElementById("preweaningmortalitycanvas").getContext('2d');
		var preweaningmortalitycanvas = new Chart(ctx13, {
	    type: 'line',
	    data: {
        labels: [@foreach($parity as $parity_number) "Parity "+"{{ $parity_number }}", @endforeach],
        datasets: [{
          label: 'Pre-weaning Mortality',
          data: [1.6,1.2,2.67,0,2.33,0],
          borderColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
          ]
        }],
        options: {
					responsive: true,
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Parity'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
	    }
		});
	</script>
@endsection