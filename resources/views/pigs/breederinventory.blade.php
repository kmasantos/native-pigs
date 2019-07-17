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
				@if($noage_sows == [])
					<p>Number of female breeders in the herd: <strong>{{ count($sows) }}</strong> (sows: {{ count($bredsows)+count($bredgilts)+count($pregnantsows)+count($lactatingsows)+$drysows }}, gilts: {{ count($gilts) }})</p>
					<p>Average age: <strong>{{ round(array_sum($age_sows)/(count($sows)-count($noage_sows)), 2) }} months</strong></p>
				@else
					<p>Number of female breeders in the herd: <strong>{{ count($sows) }}</strong> (sows: {{ count($bredsows)+count($bredgilts)+count($pregnantsows)+count($lactatingsows)+$drysows }}, gilts: {{ count($gilts) }})</p>
					<p>Average age: <strong>{{ round(array_sum($age_sows)/(count($sows)-count($noage_sows)), 2) }} months</strong> (female breeders without age data: {{ count($noage_sows) }})</p>
				@endif
				<div class="row">
					<div class="col s12 m12 l12">
						<div class="card">
							<div class="card-content grey lighten-2">
								<div class="row">
									<div class="col s4">
										<h2>{{ count($bredsows) }}</h2>
									</div>
									<div class="col s4">
										<h2>{{ count($bredgilts) }}</h2>
									</div>
									<div class="col s4">
										<h2>{{ count($pregnantsows) }}</h2>
									</div>
								</div>
								<div class="row">
									<div class="col s4">
										<p><a class="tooltipped" data-position="bottom" data-tooltip="Bred sows for the month as of today">Bred Sows</a></p>
									</div>
									<div class="col s4">
										<p><a class="tooltipped" data-position="bottom" data-tooltip="Bred gilts for the month as of today">Bred Gilts</a></p>
									</div>
									<div class="col s4">
										<p><a class="tooltipped" data-position="bottom" data-tooltip="Confirmed pregnant sows for the month as of today">Confirmed</a></p>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<p>Pregnant<a class="tooltipped" data-position="bottom" data-tooltip="Bred sows and gilts are considered pregnant">*</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col s12 m12 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<div class="row">
									<h2>{{ count($gilts) }}</h2>
								</div>
								<div class="row">
									<p><a class="tooltipped" data-position="bottom" data-tooltip="Not yet bred">Gilts</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col s12 m12 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<div class="row">
									<h2>{{ count($lactatingsows) }}</h2>
								</div>
								<div class="row">
									<p><a class="tooltipped" data-position="bottom" data-tooltip="Farrowed, not yet weaned">Lactating</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col s12 m12 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<div class="row">
									@if($drysows < 0)
										<h2>0</h2>
									@else
										<h2>{{ $drysows }}</h2>
									@endif
								</div>
								<div class="row">
									<p><a class="tooltipped" data-position="bottom" data-tooltip="Weaned and recycled sows">Dry</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- <h5>Summary</h5>
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
	      </div> --}}
			</div>
			<!-- BOAR INVENTORY -->
			<div id="boarinventory" class="col s12">
				<h5>Inventory for <strong>{{ Carbon\Carbon::parse($now)->format('F, Y') }}</strong> as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
				<p>Number of boars in the herd: <strong>{{ count($boars) }}</strong></p>
				<p>Average age: <strong>{{ round(array_sum($age_boars)/(count($srboars)+count($jrboars)), 2) }} months</strong>*</p>
				<div class="row">
					<div class="col s12 m12 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<div class="row">
									<h2>{{ count($jrboars) }}</h2>
								</div>
								<div class="row">
									<p><a class="tooltipped" data-position="bottom" data-tooltip="Less than 1 year old">Junior Boars</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col s12 m12 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<div class="row">
									<h2>{{ count($srboars) }}</h2>
								</div>
								<div class="row">
									<p><a class="tooltipped" data-position="bottom" data-tooltip="1 year old and above">Senior Boars</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				@if($noage_boars != [])
					<p>*boars without age data: {{ count($noage_boars) }}</p>
				@endif
			</div>
		</div>
		<div class="fixed-action-btn">
		  <a class="btn-floating btn-large green darken-4">
		    <i class="large material-icons">cloud_download</i>
		  </a>
		  <ul>
		    <li><a href="{{ URL::route('farm.pig.breeder_inventory_download_pdf') }}" class="btn-floating green darken-1 tooltipped" data-position="left" data-tooltip="Download as PDF"><i class="material-icons">file_copy</i></a></li>
		  </ul>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
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
		    $('.fixed-action-btn').floatingActionButton();
		  });
	</script>
@endsection