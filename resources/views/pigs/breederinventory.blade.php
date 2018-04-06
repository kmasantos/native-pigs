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
          <li class="tab col s6"><a href="#sowinventory">Sow Inventory</a></li>
          <li class="tab col s6"><a href="#boarinventory">Boar Inventory</a></li>
        </ul>
      </div>
      <!-- SOW INVENTORY -->
      <div id="sowinventory" class="col s12">
      	<div class="row">
      		<h5 class="green-text text-lighten-1">Inventory</h5>
      		<div class="col s12 m10 l6">
      			<div class="card">
      				<div class="card-content grey lighten-2">
      					<h3>{{ count($bredsows) }}</h3>
      					<p>Bred</p>
      				</div>
      			</div>
      		</div>
      		<div class="col s12 m10 l6">
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
      					<h3>{{ $lactating }}</h3>
      					<p>Lactating</p>
      				</div>
      			</div>
      		</div>
      		<div class="col s12 m10 l4">
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
      					<h3>{{ $drysows }}</h3>
      					<p>Dry</p>
      				</div>
      			</div>
      		</div>
      	</div>
      	<div class="row">
      		<h5 class="green-text text-lighten-1">Usage</h5>
	      	<table>
	      		<thead>
	      			<tr>
	      				<th>Registration ID</th>
	      				<th class="center">Usage</th>
	      				<th class="center">View Records</th>
	      			</tr>
	      		</thead>
	      		<tbody>
	      			@foreach($sows as $sow)
	      			<tr>
	      				<td>{{ $sow->registryid }}</td>
	      				<td class="center">{{ $sow->getAnimalProperties()->where("property_id", 88)->first()->value }}</td>
	      				@if($sow->getAnimalProperties()->where("property_id", 88)->first()->value == 0)
	      					<td class="center"><i class="material-icons">visibility_off</i></td>
	      				@else
	      					<td class="center"><a href="{{ URL::route('farm.pig.sow_usage', [$sow->id]) }}"><i class="material-icons">visibility</i></a></td>
	      				@endif
	      			</tr>
	      			@endforeach
	      		</tbody>
	      	</table>
	      </div>
      </div>
      <!-- BOAR INVENTORY -->
      <div id="boarinventory" class="col s12">
      	<div class="row">
      		<h5 class="green-text text-lighten-1">Inventory</h5>
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
      					<h3>{{ count($bredboars) }}</h3>
      					<p>Boars</p>
      				</div>
      			</div>
      		</div>
      	</div>
      	<div class="row">
      		<h5 class="green-text text-lighten-1">Usage</h5>
	      	<table>
	      		<thead>
	      			<tr>
	      				<th>Registration ID</th>
	      				<th class="center">Usage</th>
	      				<th class="center">View Records</th>
	      			</tr>
	      		</thead>
	      		<tbody>
	      			@foreach($boars as $boar)
	      			<tr>
	      				<td>{{ $boar->registryid }}</td>
	      				<td class="center">{{ $boar->getAnimalProperties()->where("property_id", 88)->first()->value }}</td>
	      				@if($boar->getAnimalProperties()->where("property_id", 88)->first()->value == 0)
	      					<td class="center"><i class="material-icons">visibility_off</i></td>
	      				@else
	      					<td class="center"><a href="{{ URL::route('farm.pig.boar_usage', [$boar->id]) }}"><i class="material-icons">visibility</i></a></td>
	      				@endif
	      			</tr>
	      			@endforeach
	      		</tbody>
	      	</table>
	      </div>
      </div>
		</div>
	</div>
@endsection