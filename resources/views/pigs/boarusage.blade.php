@extends('layouts.swinedefault')

@section('title')
	Boar Usage
@endsection

@section('content')
	<div class="container">
		<h5><a href="{{route('farm.pig.breeder_inventory_report')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Boar Usage: {{ $boar->registryid }}</h5>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s6">
				<p>Sow-Litter Records:</p>
				@foreach($groups as $group)
				 	@if($group->getGroupingProperties()->where("property_id", 50)->first()->value != "Recycled")
						<div class="card-panel">
							<table class="centered">
								<thead>
									<tr>
										<th>Sow Used</th>
										<th>Date Bred</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{ $group->getMother()->registryid }}</td>
										<td>{{ Carbon\Carbon::parse($group->getGroupingProperties()->where("property_id", 48)->first()->value)->format('F j, Y') }}</td>
										<td><a href="{{ URL::route('farm.pig.sowlitter_record', [$group->id]) }}"><i class="material-icons">visibility</i></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					@endif
				@endforeach
			</div>
			<div class="col s6">
				<p>Return to Heat:</p>
				@foreach($groups as $group)
					@if($group->getGroupingProperties()->where("property_id", 50)->first()->value == "Recycled")
						<div class="card-panel">
							<table class="centered">
								<thead>
									<tr>
										<th>Sow Used</th>
										<th>Date Bred</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{ $group->getMother()->registryid }}</td>
										<td>{{ Carbon\Carbon::parse($group->getGroupingProperties()->where("property_id", 48)->first()->value)->format('F j, Y') }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</div>
@endsection