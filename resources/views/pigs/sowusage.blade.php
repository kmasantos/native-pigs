@extends('layouts.swinedefault')

@section('title')
	Sow Usage
@endsection

@section('content')
	<div class="container">
		<h5><a href="{{route('farm.pig.breeder_inventory_report')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Sow Usage: {{ $sow->registryid }}</h5>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s6">
				<p>View Sow-Litter Records:</p>
				@foreach($groups as $group)
					@if($group->getGroupingProperties()->where("property_id", 50)->first()->value != "Recycled")
						<div class="card-panel"><h5><a href="{{ URL::route('farm.pig.sowlitter_record', [$group->id]) }}">{{ $group->getFather()->registryid }}</a></h5></div>
					@endif
				@endforeach
			</div>
			<div class="col s6">
				<p>Recycled:</p>
				@foreach($groups as $group)
					@if($group->getGroupingProperties()->where("property_id", 50)->first()->value == "Recycled")
						<div class="card-panel">
							<table class="centered">
								<thead>
									<tr>
										<th>Boar Used</th>
										<th>Date Bred</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{ $group->getFather()->registryid }}</td>
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