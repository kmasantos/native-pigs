@extends('layouts.swinedefault')

@section('title')
	Breeder Inventory Report
@endsection

@section('content')
	<div class="container">
		<h3>Breeder Inventory Report</h3>
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
      		<div class="col s12 m10 l6">
      			<div class="card">
      				<div class="card-content grey lighten-1">
      					<h3>#</h3>
      					<p>Number Bred</p>
      				</div>
      			</div>
      		</div>
      		<div class="col s12 m10 l6">
      			<div class="card">
      				<div class="card-content grey lighten-1">
      					<h3>#</h3>
      					<p>Number of Pregnant</p>
      				</div>
      			</div>
      		</div>
      		<div class="col s12 m10 l4">
      			<div class="card">
      				<div class="card-content grey lighten-1">
      					<h3>#</h3>
      					<p>Number of Lactating</p>
      				</div>
      			</div>
      		</div>
      		<div class="col s12 m10 l4">
      			<div class="card">
      				<div class="card-content grey lighten-1">
      					<h3>#</h3>
      					<p>Number of Gilts</p>
      				</div>
      			</div>
      		</div>
      		<div class="col s12 m10 l4">
      			<div class="card">
      				<div class="card-content grey lighten-1">
      					<h3>#</h3>
      					<p>Number of Dry</p>
      				</div>
      			</div>
      		</div>
      	</div>
      </div>
      <!-- BOAR INVENTORY -->
      <div id="boarinventory" class="col s12">
      	<table>
      		<thead>
      			<tr>
      				<th>Registration ID</th>
      				<th>Usage</th>
      			</tr>
      		</thead>
      		<tbody>
      			@foreach($boars as $boar)
      			<tr>
      				<td>{{ $boar->registryid }}</td>
      				<td>#</td>
      			</tr>
      			@endforeach
      		</tbody>
      	</table>
      </div>
		</div>
	</div>
@endsection