@extends('layouts.swinedefault')

@section('title')
	Sow-Litter Record
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.mating_record')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Sow-Litter Record</h4>
		<div class="divider"></div>
		{!! Form::open(['route' => 'farm.pig.get_sowlitter_record', 'method' => 'post']) !!}
    <div class="row">
    	<input type="hidden" name="grouping_id" value="{{ $family->id }}">
			<div class="col s12">
				<div class="row center">
					<div class="col s12">
						<div class="col s6 center">
							<h5>Sow used: {{ $family->getMother()->registryid }}</h5>
						</div>
						<div class="col s6 center">
							<h5>Boar used: {{ $family->getFather()->registryid }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 card-panel">
					<div class="row">
						<div class="col s6" style="padding-top: 10px;">
							{{-- GROUP PROPERTIES --}}
							<div class="row">

							</div>
							<div class="row">
								
							</div>
							<div class="row">
								
							</div>
							<div class="row">
								<div class="col s6">
									Date Bred
								</div>
								<div class="col s6">
									{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}
								</div>
							</div>
							<div class="row">
								<div class="col s6">
									<p>Date Farrowed</p>
								</div>
								<div class="col s6">
									<input id="date_farrowed" type="text" name="date_farrowed" placeholder="Pick date" class="datepicker">
								</div>
							</div>
							<div class="row">
								<div class="col s6">
									<p>Date Weaned</p>
								</div>
								<div class="col s6">
									<input id="date_weaned" type="text" name="date_weaned" placeholder="Pick date" class="datepicker">
								</div>
							</div>
						</div>
						<div class="col s6">
							{{-- COMPUTED VALUES --}}
							<p>Parity: </p>
							<p>Total Littersize Born: </p>
							<p>Number weaned: </p>
							<p>Average birth weight: </p>
							<p>Number of males: </p>
							<p>Number of females: </p>
							<p>Sex Ratio (Male to Female): </p>
							<p>Average weaning weight: </p>
						</div>
					</div>
				</div>
				<div class="row center">
					<div class="col s6">
						Number Stillborn
						<div class="input-field inline">
							<input id="number_stillborn" type="text" name="number_stillborn">
						</div>
					</div>
					<div class="col s6">
						Number Mummified
						<div class="input-field inline">
							<input id="number_mummified" type="text" name="number_mummified">
						</div>
					</div>
					<div class="col s12">
						<h5 class="red darken-4 white-text">Add offspring</h5>
						{{-- <input type="hidden" name="sow_registryid" value="{{ $sow->registryid }}"> --}}
						<div class="col s4">
              <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate">
              <label for="offspring_earnotch">Offspring Earnotch</label>
						</div>
						<div class="col s4">
							<select id="select_sex" name="sex" class="browser-default">
								<option disabled selected>Choose sex</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>
						</div>
						<div class="col s4">
							<input id="birth_weight" type="text" name="birth_weight">
							<label for="birth_weight">Birth Weight, kg</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<table class="centered striped">
							<thead>
								<tr class="red darken-4 white-text">
									<th>Offspring ID</th>
									<th>Sex</th>
									<th>Birth weight, kg</th>
									<th>Weaning weight, kg</th>
								</tr>
							</thead>
							<tbody>
								@forelse($offsprings as $offspring)
									<tr>
										<td>{{ $offspring->getChild()->registryid }}</td>
										<td>{{ $offspring->getAnimalProperties()->where("property_id", 27)->first()->value }}</td>
										<td>{{ $offspring->getAnimalProperties()->where("property_id", 53)->first()->value }}</td>
										<td><input id="weaning_weight" type="text" name="weaning_weight"></td>
									</tr>
								@empty
									<tr>
										<td>No offspring data found</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
				<div class="row center">
					<button class="btn waves-effect waves-light red lighten-2" type="submit">Save
            <i class="material-icons right">save</i>
          </button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
@endsection