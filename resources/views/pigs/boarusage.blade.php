@extends('layouts.swinedefault')

@section('title')
	Boar Usage
@endsection

@section('content')
	<div class="container">
		<h5><a href="{{route('farm.pig.breeder_inventory_report')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Boar Usage: {{ $boar->registryid }}</h5>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<p>View Sow-Litter Records:</p>
			@foreach($groups as $group)
				<div class="col s6 offset-s3 card-panel"><h5><a href="{{ URL::route('farm.pig.sowlitter_record', [$group->id]) }}">{{ $group->getMother()->registryid }}</a></h5></div>
			@endforeach
		</div>
	</div>
@endsection