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
	        <li class="tab"><a href="#perparityview">Per parity</a></li>
	        <li class="tab"><a href="#permonthview">Per month</a></li>
	      </ul>
	    </div>
	    <!-- PER SOW -->
	    <div id="persowview" class="col s12">	    	
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Farrowing Index</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Latest Parity</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BOAR -->
	    <div id="perboarview" class="col s12">
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Farrowing Index</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER PARITY -->
	    <div id="perparityview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports by:</p>
		  		</div>
	    		<div class="col s5">
	    		{{-- {!! Form::open(['route' => 'farm.pig.filter_production_performance_per_parity', 'method' => 'post', 'id' => 'report_filter']) !!} --}}
						<select id="filter_parity" name="filter_parity" class="browser-default" {{-- onchange="document.getElementById('report_filter').submit();" --}}>
							<option disabled selected>Parity</option>
							<option value="1">First</option>
							<option value="2">Second</option>
							<option value="3">Third</option>
							<option value="4">Fourth</option>
							<option value="5">Fifth</option>
							<option value="6">Sixth</option>
							<option value="7">Seventh</option>
							<option value="8">Eighth</option>
							<option value="9">Ninth</option>
							<option value="10">Tenth</option>
						</select>
					</div>
	    	{{-- {!! Form::close() !!} --}}
	    	</div>
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER MONTH -->
	    <div id="permonthview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports within:</p>
		  		</div>
		  		{{-- {!! Form::open(['route' => 'farm.pig.filter_production_performance_per_month', 'method' => 'post', 'id' => 'report_filter2']) !!} --}}
	    		<div class="col s2">
						<input id="start_date" type="text" class="datepicker" name="start_date" placeholder="Start date">
					</div>
					<div class="col s2">
						<input id="end_date" type="text" class="datepicker" name="end_date" placeholder="End date">
					</div>
	    		{{-- {!! Form::close() !!} --}}
	    	</div>
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
		</div>
	</div>
@endsection