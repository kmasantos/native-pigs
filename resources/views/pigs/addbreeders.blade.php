@extends('layouts.swinedefault')

@section('title')
	Add as Breeders
@endsection

@section('content')
	<div class="container">
		<h4>Add as Breeders</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
			<div class="col s12">
        <ul class="tabs tabs-fixed-width green lighten-1">
          <li class="tab col s6"><a href="#addsowbreedersview">Sows</a></li>
          <li class="tab col s6"><a href="#addboarbreedersview">Boars</a></li>
        </ul>
      </div>
      <div id="addsowbreedersview" class="col s12">
				<table>
					<thead>
						<tr>
							<th>Registration ID</th>
							<th class="center">Add as Breeder</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sows as $sow)
							<tr>
								<td>{{ $sow->registryid }}</td>
								<td class="center">
									<p>
							      <label>
							        <input type="checkbox" class="filled-in" />
							        <span></span>
							      </label>
							    </p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div id="addboarbreedersview" class="col s12">
				<table>
					<thead>
						<tr>
							<th>Registration ID</th>
							<th class="center">Add as Breeder</th>
						</tr>
					</thead>
					<tbody>
						@foreach($boars as $boar)
							<tr>
								<td>{{ $boar->registryid }}</td>
								<td class="center">
									<p>
							      <label>
							        <input type="checkbox" class="filled-in" />
							        <span></span>
							      </label>
							    </p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection