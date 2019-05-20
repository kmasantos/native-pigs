@extends('layouts.swinedefault')

@section('title')
	Gross Morphology Report
@endsection

@section('content')
	<div class="container">
		<h4>Gross Morphology Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			{!! Form::open(['route' => 'farm.pig.filter_gross_morphology_report', 'method' => 'post', 'id' => 'report_filter']) !!}
	  	<div class="row">
	  		<div class="col s12">
	  			<h5 class="center">Data as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
	  		</div>
	  		<div class="col s4 offset-s1">
	  			<p>Generate Reports by:</p>
	  		</div>
	  		<div class="col s5">
					<select id="filter_keywords" name="filter_keywords" class="browser-default" onchange="document.getElementById('report_filter').submit();">
						<option disabled selected>{{ $filter }}</option>
						<option value="Sow">Sow</option>
						<option value="Boar">Boar</option>
						<option value="All">All pigs</option>
					</select>
				</div>
	    	{!! Form::close() !!}
	  	</div>

			<div class="row">
		    <div class="col s12">
		      <ul class="tabs tabs-fixed-width green lighten-1">
		        <li class="tab col s6"><a href="#herdview">Breeders</a></li>
		        <li class="tab col s6"><a href="#yearofbirthview">Year of Birth</a></li>
		      </ul>
		    </div>
		    <!-- HERD VIEW -->
		    <div id="herdview" class="col s12">
		    	<div class="row center">
			    	<div class="col s12">
			  			@if($filter == "All")
			  				<p class="center">Total number of breeders: <strong>{{ count($alive) }}</strong></p>
			  			@elseif($filter == "Sow")
			  				<p class="center">Total number of sows: <strong>{{ count($sowsalive) }}</strong></p>
			  			@elseif($filter == "Boar")
			  				<p class="center">Total number of boars: <strong>{{ count($boarsalive) }}</strong></p>
			  			@endif
			  		</div>
			  	</div>
			  	<div class="row">
				    <div class="col s12">
				      <ul class="tabs smalltabs">
				        <li class="tab col s2 offset-s4"><a href="#tableview"><i class="material-icons">border_all</i></a></li>
				        <li class="tab col s2"><a href="#chartview"><i class="material-icons">pie_chart</i></a></li>
				      </ul>
				    </div>
				    <!-- TABLE -->
				    <div id="tableview" class="col s12">
				    	<div class="row center">
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Hair Type</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Curly</th>
				    						<th>Straight</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($curlyhairs == [] && $straighthairs == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
					    						@if($filter == "Sow")
							    					<td>{{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($straighthairs) }} ({{ round((count($straighthairs)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $nohairtypes }} ({{ round(($nohairtypes/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($straighthairs) }} ({{ round((count($straighthairs)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $nohairtypes }} ({{ round(($nohairtypes/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($straighthairs) }} ({{ round((count($straighthairs)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $nohairtypes }} ({{ round(($nohairtypes/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Hair Length</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Short</th>
				    						<th>Long</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
							    			@if($shorthairs == [] && $longhairs == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($shorthairs) }} ({{ round((count($shorthairs)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($longhairs) }} ({{ round((count($longhairs)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $nohairlengths }} ({{ round(($nohairlengths/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
							    					<td>{{ count($shorthairs) }} ({{ round((count($shorthairs)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($longhairs) }} ({{ round((count($longhairs)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $nohairlengths }} ({{ round(($nohairlengths/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
							    					<td>{{ count($shorthairs) }} ({{ round((count($shorthairs)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($longhairs) }} ({{ round((count($longhairs)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $nohairlengths }} ({{ round(($nohairlengths/count($pigs))*100, 2) }}%)</td>
							    				@endif
							    			@endif
							    		</tr>
							    	</tbody>
							    </table>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Coat Color</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Black</th>
				    						<th>Others</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($blackcoats == [] && $nonblackcoats == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($blackcoats) }} ({{ round((count($blackcoats)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $nocoats }} ({{ round(($nocoats/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($blackcoats) }} ({{ round((count($blackcoats)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $nocoats }} ({{ round(($nocoats/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($blackcoats) }} ({{ round((count($blackcoats)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $nocoats }} ({{ round(($nocoats/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Color Pattern</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Plain</th>
				    						<th>Socks</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($plains == [] && $socks == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($plains) }} ({{ round((count($plains)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($socks) }} ({{ round((count($socks)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $nopatterns }} ({{ round(($nopatterns/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($plains) }} ({{ round((count($plains)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($socks) }} ({{ round((count($socks)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $nopatterns }} ({{ round(($nopatterns/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($plains) }} ({{ round((count($plains)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($socks) }} ({{ round((count($socks)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $nopatterns }} ({{ round(($nopatterns/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Head Shape</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Concave</th>
				    						<th>Straight</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($concaves == [] && $straightheads == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($concaves) }} ({{ round((count($concaves)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($straightheads) }} ({{ round((count($straightheads)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $noheadshapes }} ({{ round(($noheadshapes/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($concaves) }} ({{ round((count($concaves)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($straightheads) }} ({{ round((count($straightheads)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $noheadshapes }} ({{ round(($noheadshapes/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($concaves) }} ({{ round((count($concaves)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($straightheads) }} ({{ round((count($straightheads)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $noheadshapes }} ({{ round(($noheadshapes/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Skin Type</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Smooth</th>
				    						<th>Wrinkled</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($smooths == [] && $wrinkleds == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($smooths) }} ({{ round((count($smooths)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $noskintypes }} ({{ round(($noskintypes/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($smooths) }} ({{ round((count($smooths)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $noskintypes }} ({{ round(($noskintypes/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($smooths) }} ({{ round((count($smooths)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $noskintypes }} ({{ round(($noskintypes/count($pigs))*100, 2) }}%)</td>
								    			@endif
							  				@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Ear Type</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Drooping</th>
				    						<th>Semi-lop</th>
				    						<th>Erect</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($droopingears == [] && $semilops == [] && $erectears == [])
							  					<td colspan="4" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($droopingears) }} ({{ round((count($droopingears)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($semilops) }} ({{ round((count($semilops)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($erectears) }} ({{ round((count($erectears)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $noeartypes }} ({{ round(($noeartypes/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($droopingears) }} ({{ round((count($droopingears)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($semilops) }} ({{ round((count($semilops)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($erectears) }} ({{ round((count($erectears)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $noeartypes }} ({{ round(($noeartypes/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($droopingears) }} ({{ round((count($droopingears)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($semilops) }} ({{ round((count($semilops)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($erectears) }} ({{ round((count($erectears)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $noeartypes }} ({{ round(($noeartypes/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    		<div class="col s6">
				    			<p class="green-text text-lighten-1">Tail Type</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Curly</th>
				    						<th>Straight</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($curlytails == [] && $straighttails == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($curlytails) }} ({{ round((count($curlytails)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($straighttails) }} ({{ round((count($straighttails)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $notailtypes }} ({{ round(($notailtypes/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($curlytails) }} ({{ round((count($curlytails)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($straighttails) }} ({{ round((count($straighttails)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $notailtypes }} ({{ round(($notailtypes/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($curlytails) }} ({{ round((count($curlytails)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($straighttails) }} ({{ round((count($straighttails)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $notailtypes }} ({{ round(($notailtypes/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6 offset-s3">
				    			<p class="green-text text-lighten-1">Backline</p>
				    			<table class="centered">
				    				<thead>
				    					<tr>
				    						<th>Swayback</th>
				    						<th>Straight</th>
				    						<th>No record</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr>
				    						@if($swaybacks == [] && $straightbacks == [])
							  					<td colspan="3" class="center">No data available</td>
							  				@else
							  					@if($filter == "Sow")
								    				<td>{{ count($swaybacks) }} ({{ round((count($swaybacks)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ count($straightbacks) }} ({{ round((count($straightbacks)/count($sows))*100, 2) }}%)</td>
								    				<td>{{ $nobacklines }} ({{ round(($nobacklines/count($sows))*100, 2) }}%)</td>
								    			@elseif($filter == "Boar")
								    				<td>{{ count($swaybacks) }} ({{ round((count($swaybacks)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ count($straightbacks) }} ({{ round((count($straightbacks)/count($boars))*100, 2) }}%)</td>
								    				<td>{{ $nobacklines }} ({{ round(($nobacklines/count($boars))*100, 2) }}%)</td>
								    			@elseif($filter == "All")
								    				<td>{{ count($swaybacks) }} ({{ round((count($swaybacks)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ count($straightbacks) }} ({{ round((count($straightbacks)/count($pigs))*100, 2) }}%)</td>
								    				<td>{{ $nobacklines }} ({{ round(($nobacklines/count($pigs))*100, 2) }}%)</td>
								    			@endif
								    		@endif
				    					</tr>
				    				</tbody>
				    			</table>
				    		</div>
				    	</div>
				    </div>
				    <!-- PIE CHARTS -->
				    <div id="chartview" class="col s12">
				    	<div class="row center">
				    		<div class="col s6">
				    			<p>Hair Type</p>
				    			<canvas id="hairtypecanvas"></canvas>
				    		</div>
				    		<div class="col s6">
				    			<p>Hair Length</p>
				    			<canvas id="hairlengthcanvas"></canvas>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6">
				    			<p>Coat Color</p>
				    			<canvas id="coatcolorcanvas"></canvas>
				    		</div>
				    		<div class="col s6">
				    			<p>Color Pattern</p>
				    			<canvas id="colorpatterncanvas"></canvas>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6">
				    			<p>Head Shape</p>
				    			<canvas id="headshapecanvas"></canvas>
				    		</div>
				    		<div class="col s6">
				    			<p>Skin Type</p>
				    			<canvas id="skintypecanvas"></canvas>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6">
				    			<p>Ear Type</p>
				    			<canvas id="eartypecanvas"></canvas>
				    		</div>
				    		<div class="col s6">
				    			<p>Tail Type</p>
				    			<canvas id="tailtypecanvas"></canvas>
				    		</div>
				    	</div>
				    	<div class="row center">
				    		<div class="col s6 offset-s3">
				    			<p>Backline</p>
				    			<canvas id="backlinecanvas"></canvas>
				    		</div>
				    	</div>
				    </div>
			    </div>
			  </div>
		    <!-- YEAR OF BIRTH VIEW -->
		    <div id="yearofbirthview" class="col s12">
		    	<div class="row center">
			    	<div class="col s12">
			  			@if($filter == "All")
			  				<p class="center">Total number of pigs: <strong>{{ count($pigs) }}</strong> (Active: <strong>{{ count($alive) }}</strong>, Sold: <strong>{{ count($sold) }}</strong>, Dead: <strong>{{ count($dead) }}</strong>, Removed: <strong>{{ count($removed) }}</strong>)</p>
			  			@elseif($filter == "Sow")
			  				<p class="center">Total number of sows: <strong>{{ count($sows) }}</strong> (Active: <strong>{{ count($sowsalive) }}</strong>, Sold: <strong>{{ count($soldsows) }}</strong>, Dead: <strong>{{ count($deadsows) }}</strong>, Removed: <strong>{{ count($removedsows) }}</strong>)</p>
			  			@elseif($filter == "Boar")
			  				<p class="center">Total number of boars: <strong>{{ count($boars) }}</strong> (Active: <strong>{{ count($boarsalive) }}</strong>, Sold: <strong>{{ count($soldboars) }}</strong>, Dead: <strong>{{ count($deadboars) }}</strong>, Removed: <strong>{{ count($removedboars) }}</strong>)</p>
			  			@endif
			  		</div>
			  	</div>
		    	<div class="row center">
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Hair Type</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Curly</th>
		    						<th>Straight</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Curly") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Straight") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Curly")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Curly"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Straight")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Straight"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Curly"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Straight"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Curly"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 11, $filter, "Straight"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Hair Length</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Short</th>
		    						<th>Long</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Short") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Long") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Short")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Short"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Long")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Long"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Short"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Long"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Short"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 12, $filter, "Long"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>
		    	<div class="row center">
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Coat Color</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Black</th>
		    						<th>Others</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Black") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Others") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Black")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Black"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Others")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Others"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Black"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Others"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Black"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 13, $filter, "Others"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Color Pattern</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Plain</th>
		    						<th>Socks</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Plain") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Socks") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Plain")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Plain"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Socks")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Socks"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Plain"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Socks"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Plain"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 14, $filter, "Socks"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>
		    	<div class="row center">
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Head Shape</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Concave</th>
		    						<th>Straight</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Concave") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Straight") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Concave")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Concave"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Straight")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Straight"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Concave"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Straight"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Concave"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 15, $filter, "Straight"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Skin Type</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Smooth</th>
		    						<th>Wrinkled</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Smooth") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Wrinkled") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Smooth")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Smooth"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Wrinkled")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Wrinkled"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Smooth"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Wrinkled"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Smooth"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 16, $filter, "Wrinkled"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>
		    	<div class="row center">
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Ear Type</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Drooping</th>
		    						<th>Semi-lop</th>
		    						<th>Erect</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Drooping") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Semi-lop") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Erect") == [])
			    							<td colspan="4">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Drooping")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Drooping"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Semi-lop")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Semi-lop"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Erect")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Erect"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Drooping"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Semi-lop"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Erect"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Drooping"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Semi-lop"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 17, $filter, "Erect"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    		<div class="col s6">
		    			<p class="green-text text-lighten-1">Tail Type</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Curly</th>
		    						<th>Straight</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Curly") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Straight") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Curly")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Curly"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Straight")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Straight"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Curly"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Straight"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Curly"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 18, $filter, "Straight"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
		    		</div>
		    	</div>
		    	<div class="row center">
		    		<div class="col s6 offset-s3">
		    			<p class="green-text text-lighten-1">Backline</p>
		    			<table class="centered">
		    				<thead>
		    					<tr>
		    						<th>Year</th>
		    						<th>Swayback</th>
		    						<th>Straight</th>
		    						<th>No record</th>
		    					</tr>
		    				</thead>
		    				<tbody>
		    					@forelse($years as $year)
			    					<tr>
			    						<td>{{ $year }}</td>
			    						@if(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Swayback") == [] && App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Straight") == [])
			    							<td colspan="3">No data available</td>
			    						@else
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Swayback")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Swayback"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Straight")) }} ({{ round(((count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Straight"))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))))*100, 2) }}%)</td>
			    							<td>{{ count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Swayback"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Straight"))) }} ({{ round(((count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter))-(count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Swayback"))+count(App\Http\Controllers\FarmController::getGrossMorphologyPerYearOfBirth($year, 19, $filter, "Straight"))))/count(App\Http\Controllers\FarmController::getNumPigsBornOnYear($year, $filter)))*100, 2) }}%)</td>
			    						@endif
			    					</tr>
			    				@empty
			    					<tr>
			    						<td colspan="4">No data available</td>
			    					</tr>
			    				@endforelse
		    				</tbody>
		    			</table>
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
		var ctx1 = document.getElementById("hairtypecanvas").getContext('2d');
		var hairtypechart = new Chart(ctx1, {
	    type: 'pie',
	    data: {
        labels: ["Curly", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Type',
          data: [{{ count($curlyhairs) }}, {{ count($straighthairs) }}, {{ $nohairtypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx2 = document.getElementById("hairlengthcanvas").getContext('2d');
		var hairlengthchart = new Chart(ctx2, {
			type: 'pie',
	    data: {
        labels: ["Short", "Long", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($shorthairs) }}, {{ count($longhairs) }}, {{ $nohairlengths }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx3 = document.getElementById("coatcolorcanvas").getContext('2d');
		var coatcolorchart = new Chart(ctx3, {
			type: 'pie',
	    data: {
        labels: ["Black", "Others", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($blackcoats) }}, {{ count($nonblackcoats) }}, {{ $nocoats }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx4 = document.getElementById("colorpatterncanvas").getContext('2d');
		var colorpatternchart = new Chart(ctx4, {
			type: 'pie',
	    data: {
        labels: ["Plain", "Socks", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($plains) }}, {{ count($socks) }}, {{ $nopatterns }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx5 = document.getElementById("headshapecanvas").getContext('2d');
		var headshapechart = new Chart(ctx5, {
			type: 'pie',
	    data: {
        labels: ["Concave", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($concaves) }}, {{ count($straightheads) }}, {{ $noheadshapes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx6 = document.getElementById("skintypecanvas").getContext('2d');
		var skintypechart = new Chart(ctx6, {
			type: 'pie',
	    data: {
        labels: ["Smooth", "Wrinkled", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($smooths) }}, {{ count($wrinkleds) }}, {{ $noskintypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx7 = document.getElementById("eartypecanvas").getContext('2d');
		var eartypechart = new Chart(ctx7, {
			type: 'pie',
	    data: {
        labels: ["Drooping", "Semi-lop", "Erect", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($droopingears) }}, {{ count($semilops) }}, {{ count($erectears)}}, {{ $noeartypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx8 = document.getElementById("tailtypecanvas").getContext('2d');
		var tailtypechart = new Chart(ctx8, {
			type: 'pie',
	    data: {
        labels: ["Curly", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($curlytails) }}, {{ count($straighttails) }}, {{ $notailtypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
		var ctx9 = document.getElementById("backlinecanvas").getContext('2d');
		var backlinechart = new Chart(ctx9, {
			type: 'pie',
	    data: {
        labels: ["Swayback", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($swaybacks) }}, {{ count($straightbacks) }}, {{ $nobacklines }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)'
          ]
        }]
	    }
		});
	</script>
@endsection