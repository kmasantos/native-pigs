@extends('layouts.swinedefault')

@section('title')
	Average Daily Gain
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.grower_records')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Average Daily Gain: <strong>{{ $pig->registryid }}</strong></h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12 m10 l6">
				<div class="card">
					<div class="card-content grey lighten-2">
						@if($adg_birth != "")
							<h3>{{ round($adg_birth, 2) }} kg</h3>
						@else
							<h4>No data available</h4>
						@endif
						<p>From Birth</p>
					</div>
					<div class="card-action">
						@if(!is_null($properties->where("property_id", 53)->first()))
							@if($properties->where("property_id", 53)->first()->value != "")
								<p>Birth Weight: <strong>{{ $properties->where("property_id", 53)->first()->value }} kg</strong></p>
							@else
								<p>Birth Weight: <strong>No data available</strong></p>
							@endif
						@else
							<p>Birth Weight: <strong>No data available</strong></p>
						@endif
						@if(!is_null($properties->where("property_id", 25)->first()))
							@if($properties->where("property_id", 25)->first()->value != "Not specified")
								<p>Birth Date: <strong>{{ Carbon\Carbon::parse($properties->where("property_id", 25)->first()->value)->format('j F, Y') }}</strong></p>
							@else
								<p>Birth Date: <strong>No data available</strong></p>
							@endif
						@else
							<p>Birth Date: <strong>No data available</strong></p>
						@endif
					</div>
				</div>
			</div>
			<div class="col s12 m10 l6">
				<div class="card">
					<div class="card-content grey lighten-2">
						@if($adg_weaning != "")
							@if($adg_weaning == 0)
								<h3>0 kg</h3>
							@else
								<h3>{{ round($adg_weaning, 2) }} kg</h3>
							@endif
						@else
							@if(!is_null($properties->where("property_id", 54)->first()))
								<h3>0 kg</h3>
							@else
								<h4>No data available</h4>
							@endif
						@endif
						<p>From Weaning</p>
					</div>
					<div class="card-action">
						@if(!is_null($properties->where("property_id", 54)->first()))
							@if($properties->where("property_id", 54)->first()->value != "")
								<p>Weaning Weight: <strong>{{ $properties->where("property_id", 54)->first()->value }} kg</strong></p>
							@else
								<p>Weaning Weight: <strong>No data available</strong></p>
							@endif
						@else
							<p>Weaning Weight: <strong>No data available</strong></p>
						@endif
						@if(!is_null($properties->where("property_id", 61)->first()))
							@if($properties->where("property_id", 61)->first()->value != "Not specified")
								<p>Date Weaned: <strong>{{ Carbon\Carbon::parse($properties->where("property_id", 61)->first()->value)->format('j F, Y') }}</strong></p>
							@else
								<p>Date Weaned: <strong>No data available</strong></p>
							@endif
						@else
							<p>Date Weaned: <strong>No data available</strong></p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection