@extends('layouts.swinedefault')

@section('title')
	Breeder Inventory Report
@endsection

@section('content')
	<div class="container">
		<h4>Breeder Inventory Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12">
			  <ul class="tabs tabs-fixed-width green lighten-1">
			    <li class="tab"><a href="#sowinventory">Sow Inventory</a></li>
			    <li class="tab"><a href="#boarinventory">Boar Inventory</a></li>
			  </ul>
			</div>
			<!-- SOW INVENTORY -->
			<div id="sowinventory" class="col s12">
				<h5>Inventory for <strong>{{ Carbon\Carbon::parse($now)->format('F, Y') }}</strong> as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
				<p>Number of sows in the herd: <strong>{{ count($sows) }}</strong></p>
				<div class="row">
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($breds) }}</h3>
								<p><a class="tooltipped" data-position="bottom" data-tooltip="Bred sows for the month as of today">Bred</a></p></p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($gilts) }}</h3>
								<p><a class="tooltipped" data-position="bottom" data-tooltip="Not yet bred sows">Gilts</a></p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($pregnantsows) }}</h3>
								<p><a class="tooltipped" data-position="bottom" data-tooltip="Pregnant sows for the month as of today">Pregnant</a></p></p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($lactatingsows) }}</h3>
								<p><a class="tooltipped" data-position="bottom" data-tooltip="Farrowed, not yet weaned">Lactating</a></p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								@if($drysows < 0)
									<h3>0</h3>
								@else
									<h3>{{ $drysows }}</h3>
								@endif
								<p><a class="tooltipped" data-position="bottom" data-tooltip="Weaned and recycled sows">Dry</a></p>
							</div>
						</div>
					</div>
				</div>
				<h5>Summary</h5>
				<div class="col s12">
        	<ul class="collapsible popout">
        		@foreach($years as $year)
	            <li>
	              <div class="collapsible-header grey lighten-2">{{ $year }}</div>
	              <div class="collapsible-body">
	              	<table class="centered">
	              		<thead>
	              			<tr>
	              				<th class="grey lighten-2">Month</th>
	              				<th>Bred</th>
	              				<th class="grey lighten-2">Pregnant</th>
	              				<th>Lactating</th>
	              				<th class="grey lighten-2">Dry</th>
	              			</tr>
	              		</thead>
	              		<tbody>
	              			@foreach($months as $month)
	              				<tr>
	              					<td class="grey lighten-2">{{ $month }}</td>
	              					<td>{{ App\Http\Controllers\FarmController::getMonthlyBredSows($year, $month) }}</td>
	              					<td class="grey lighten-2">{{ App\Http\Controllers\FarmController::getMonthlyPregnantSows($year, $month) }}</td>
	              					<td>{{ App\Http\Controllers\FarmController::getMonthlyLactatingSows($year, $month) }}</td>
	              					<td class="grey lighten-2">{{ App\Http\Controllers\FarmController::getMonthlyDrySows($year, $month, count($sows)) }}</td>
	              				</tr>
	              			@endforeach
	              		</tbody>
	              	</table>
	              </div>
	            </li>
	          @endforeach
	        </ul>
	      </div>
			</div>
			<!-- BOAR INVENTORY -->
			<div id="boarinventory" class="col s12">
				<h5>Inventory for <strong>{{ Carbon\Carbon::parse($now)->format('F, Y') }}</strong> as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
				<p>Number of boars in the herd: <strong>{{ count($boars) }}</strong></p>
				<div class="row">
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($jrboars) }}</h3>
								<p><a class="tooltipped" data-position="bottom" data-tooltip="Less than 1 year old">Junior Boars</a></p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($srboars) }}</h3>
								<p><a class="tooltipped" data-position="bottom" data-tooltip="1 year old and above">Senior Boars</a></p>
							</div>
						</div>
					</div>
				</div>
				@if($noage != [])
					<p>*boars without age data: {{ count($noage) }}</p>
				@endif
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
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
		});
	</script>
@endsection