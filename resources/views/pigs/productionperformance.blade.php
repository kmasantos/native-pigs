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
	    	<div class="row center" style="padding-top: 10px;">
	    		<div class="col s12">
	    			<ul class="collapsible popout">
	    				<li>
	    					<div class="collapsible-header grey lighten-2">Summary</div>
	              <div class="collapsible-body">
	                <table>
	                	<thead>
	                		<tr>
	                			<th>Parameters</th>
	                			<th class="center">Average</th>
	                			<th class="center">Standard Deviation</th>
	                		</tr>
	                	</thead>
	                	<tbody>
	                		<tr>
	                			<td>Litter-size Born Alive</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "lsba") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "lsba"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "lsba")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "lsba"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Male Born</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number males") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number males"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number males")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number males"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Female Born</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number females") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number females"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number females")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number females"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Stillborn</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "stillborn") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "stillborn"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "stillborn")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "stillborn"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Mummified</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "mummified") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "mummified"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "mummified")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "mummified"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Litter Birth Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter bw") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter bw"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter bw")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter bw"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Average Birth Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave bw") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave bw"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave bw")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave bw"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Litter Weaning Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter ww") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter ww"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter ww")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "litter ww"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Average Weaning Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave ww") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave ww"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave ww")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "ave ww"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Adjusted Weaning Weight at 45 Days, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "adj ww") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "adj ww"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "adj ww")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "adj ww"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Weaned</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number weaned") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number weaned"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number weaned")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "number weaned"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Age Weaned, days</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "age weaned") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "age weaned"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "age weaned")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "age weaned"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Pre-weaning Mortality, %</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "preweaning mortality") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "preweaning mortality"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "preweaning mortality")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("sow", "preweaning mortality"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                	</tbody>
	                </table>
	              </div>
	    				</li>
	    			</ul>
	    		</div>
	    		@if($archived_sows != [])
		    		<div class="col s12">
		    			<ul class="collapsible popout">
		    				<li>
		    					<div class="collapsible-header grey lighten-2">Archive</div>
		              <div class="collapsible-body">
		              	<table>
							    		<thead>
							    			<tr>
							    				<th>Registration ID</th>
							    				<th class="center">View Production Performance</th>
							    			</tr>
							    		</thead>
							    		<tbody>
							    			@foreach($archived_sows as $archived_sow)
								    			<tr>
								    				<td>{{ $archived_sow->registryid }}</td>
								    				<td class="center"><a href="{{ URL::route('farm.pig.sow_production_performance', [$archived_sow->id]) }}"><i class="material-icons">visibility</i></a></td>
								    			</tr>
								    		@endforeach
							    		</tbody>
							    	</table>
		              </div>
		            </li>
		          </ul>
		        </div>
		      @endif
	      </div>
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
	    	<div class="row center" style="padding-top: 10px;">
	    		<div class="col s12">
	    			<ul class="collapsible popout">
	    				<li>
	    					<div class="collapsible-header grey lighten-2">Summary</div>
	              <div class="collapsible-body">
	                <table>
	                	<thead>
	                		<tr>
	                			<th>Parameters</th>
	                			<th class="center">Average</th>
	                			<th class="center">Standard Deviation</th>
	                		</tr>
	                	</thead>
	                	<tbody>
	                		<tr>
	                			<td>Litter-size Born Alive</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "lsba") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "lsba"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "lsba")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "lsba"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Male Born</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number males") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number males"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number males")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number males"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Female Born</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number females") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number females"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number females")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number females"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Stillborn</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "stillborn") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "stillborn"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "stillborn")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "stillborn"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Mummified</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "mummified") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "mummified"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "mummified")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "mummified"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Litter Birth Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter bw") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter bw"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter bw")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter bw"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Average Birth Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave bw") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave bw"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave bw")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave bw"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Litter Weaning Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter ww") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter ww"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter ww")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "litter ww"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Average Weaning Weight, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave ww") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave ww"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave ww")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "ave ww"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Adjusted Weaning Weight at 45 Days, kg</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "adj ww") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "adj ww"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "adj ww")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "adj ww"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Number Weaned</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number weaned") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number weaned"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number weaned")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "number weaned"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Age Weaned, days</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "age weaned") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "age weaned"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "age weaned")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "age weaned"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                		<tr>
	                			<td>Pre-weaning Mortality, %</td>
	                			@if(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "preweaning mortality") == "")
		         							<td class="center" colspan="2">No data available</td>
		                		@else
		                			<td class="center">{{ round(array_sum(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "preweaning mortality"))/count(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "preweaning mortality")), 2) }}</td>
		                			<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getProductionPerformanceSummary("boar", "preweaning mortality"), false), 2) }}</td>
		                		@endif
	                		</tr>
	                	</tbody>
	                </table>
	              </div>
	    				</li>
	    			</ul>
	    		</div>
	    		@if($archived_boars != [])
		    		<div class="col s12">
		    			<ul class="collapsible popout">
		    				<li>
		    					<div class="collapsible-header grey lighten-2">Archive</div>
		              <div class="collapsible-body">
		              	<table>
							    		<thead>
							    			<tr>
							    				<th>Registration ID</th>
							    				<th class="center">View Production Performance</th>
							    			</tr>
							    		</thead>
							    		<tbody>
							    			@foreach($archived_boars as $archived_boar)
								    			<tr>
								    				<td>{{ $archived_boar->registryid }}</td>
								    				<td class="center"><a href="{{ URL::route('farm.pig.boar_production_performance', [$archived_boar->id]) }}"><i class="material-icons">visibility</i></a></td>
								    			</tr>
								    		@endforeach
							    		</tbody>
							    	</table>
		              </div>
		            </li>
		          </ul>
		        </div>
		      @endif
	    	</div>
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
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($lsba, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Male Born</td>
			    				@if($numbermales == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($numbermales)/count($numbermales), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($numbermales, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Female Born</td>
			    				@if($numberfemales == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($numberfemales)/count($numberfemales), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($numberfemales, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Stillborn</td>
			    				@if($stillborn == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($stillborn, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Mummified</td>
			    				@if($mummified == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($mummified, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Litter Birth Weight, kg</td>
			    				@if($litterbirthweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($litterbirthweights)/count($litterbirthweights), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($litterbirthweights, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Average Birth Weight, kg</td>
			    				@if($avebirthweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($avebirthweights)/count($avebirthweights), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($avebirthweights, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Litter Weaning Weight, kg</td>
			    				@if($litterweaningweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($litterweaningweights)/count($litterweaningweights), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($litterweaningweights, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Average Weaning Weight, kg</td>
			    				@if($aveweaningweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($aveweaningweights)/count($aveweaningweights), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($aveweaningweights, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Adjusted Weaning Weight at 45 Days, kg</td>
			    				@if($adjweaningweights == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($adjweaningweights)/count($adjweaningweights), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($adjweaningweights, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Number Weaned</td>
			    				@if($numberweaned == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($numberweaned)/count($numberweaned), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($numberweaned, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Age Weaned, days</td>
			    				@if($agesweaned == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($agesweaned)/count($agesweaned), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($agesweaned, false), 2) }}</td>
									@endif
			    			</tr>
			    			<tr>
			    				<td>Pre-weaning Mortality, %</td>
			    				@if($preweaningmortality == [])
				    				<td class="center">No data available</td>
				    				<td class="center">No data available</td>
				    			@else
				    				<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
										<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($preweaningmortality, false), 2) }}</td>
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
			    				<p>Age Weaned, days</p>
					    		<canvas id="ageweanedcanvas"></canvas>
			    			</div>
			    			<div class="col s6">
			    				<p>Pre-weaning Mortality, %</p>
					    		<canvas id="preweaningmortalitycanvas"></canvas>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			  </div>
	    </div>
		</div>
		<div class="fixed-action-btn">
		  <a class="btn-floating btn-large green darken-4">
		    <i class="large material-icons">cloud_download</i>
		  </a>
		  <ul>
		    <li><a class="btn-floating green lighten-1 tooltipped" data-position="left" data-tooltip="Download as CSV File"><i class="material-icons">table_chart</i></a></li>
		  </ul>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
	    $('.fixed-action-btn').floatingActionButton();
	  });
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "lsba") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "number of males") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "number of females") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "stillborn") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "mummified") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "birth weight") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "ave birth weight") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "weaning weight") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "ave weaning weight") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "adj weaning weight") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "number weaned") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "age weaned") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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
          data: [@foreach($parity as $parity_number) {{ App\Http\Controllers\FarmController::getPropertyAveragePerParity($parity_number, "preweaning mortality") }}, @endforeach],
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'transparent'
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