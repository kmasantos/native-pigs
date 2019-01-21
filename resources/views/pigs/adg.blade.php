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
							<p>Latest weight record: {{ $number_of_days }} days</p>
						@else
							<h4>No data available</h4>
						@endif
						<h5>From Birth</h5>
					</div>
					<div class="card-action">
						@if(!is_null($properties->where("property_id", 5)->first()))
							@if($properties->where("property_id", 5)->first()->value != "")
								<p>Birth Weight: <strong>{{ $properties->where("property_id", 5)->first()->value }} kg</strong></p>
							@else
								<p>Birth Weight: <strong>No data available</strong></p>
							@endif
						@else
							<p>Birth Weight: <strong>No data available</strong></p>
						@endif
						@if(!is_null($properties->where("property_id", 3)->first()))
							@if($properties->where("property_id", 3)->first()->value != "Not specified")
								<p>Birth Date: <strong>{{ Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->format('j F, Y') }}</strong></p>
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
								<p>Latest weight record: {{ $number_of_days }} days</p>
							@endif
						@elseif($adg_weaning == 0)
							@if(!is_null($properties->where("property_id", 7)->first()))
								<h4>No data available</h4>
							@endif
						@else
							@if(!is_null($properties->where("property_id", 7)->first()))
								<h3>0 kg</h3>
							@else
								<h4>No data available</h4>
							@endif
						@endif
						<h5>From Weaning</h5>
					</div>
					<div class="card-action">
						@if(!is_null($properties->where("property_id", 7)->first()))
							@if($properties->where("property_id", 7)->first()->value != "")
								<p>Weaning Weight: <strong>{{ $properties->where("property_id", 7)->first()->value }} kg</strong></p>
							@else
								<p>Weaning Weight: <strong>No data available</strong></p>
							@endif
						@else
							<p>Weaning Weight: <strong>No data available</strong></p>
						@endif
						@if(!is_null($properties->where("property_id", 6)->first()))
							@if($properties->where("property_id", 6)->first()->value != "Not specified")
								<p>Date Weaned: <strong>{{ Carbon\Carbon::parse($properties->where("property_id", 6)->first()->value)->format('j F, Y') }}</strong></p>
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