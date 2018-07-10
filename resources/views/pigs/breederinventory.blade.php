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
								<p>Bred</p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($gilts) }}</h3>
								<p>Gilts</p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($pregnantsows) }}</h3>
								<p>Pregnant</p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($lactatingsows) }}</h3>
								<p>Lactating</p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l4">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ $drysows }}</h3>
								<p>Dry</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- BOAR INVENTORY -->
			<div id="boarinventory" class="col s12">
				<h5>Inventory for {{ Carbon\Carbon::parse($now)->format('F, Y') }} as of {{ Carbon\Carbon::parse($now)->format('F j, Y') }}</h5>
				<p>Number of boars in the herd: <strong>{{ count($boars) }}</strong></p>
				<div class="row">
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($jrboars) }}</h3>
								<p>Junior Boars</p>
							</div>
						</div>
					</div>
					<div class="col s12 m10 l6">
						<div class="card">
							<div class="card-content grey lighten-2">
								<h3>{{ count($srboars) }}</h3>
								<p>Boars</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection