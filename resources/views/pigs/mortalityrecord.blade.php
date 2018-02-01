@extends('layouts.swinedefault')

@section('title')
	Mortality Record
@endsection

@section('content')
	<h4 class="headline">Mortality Record</h4>
	<div class="container">
		<div class="row">
      <div class="col s12">
				<div class="row">
					<div class="col s12">
						<div class="row">
							<div class="col s4">
								<select name="month_mortality" class="browser-default">
									<option disabled selected>Choose month</option>
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
								</select>
							</div>
						</div>
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr>
										<th>Registration ID</th>
										<th>Date of Death</th>
										<th>Age, months</th>
									</tr>
								</thead>
								<tbody>
									@foreach($dead as $dead_pig)
										<tr>
											<td>{{ $dead_pig->registryid }}</td>
											<td>{{ $dead_pig->getAnimalProperties()->where("property_id", 55)->first()->value }}</td>
											<td>XX</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						{!! Form::open(['route' => 'farm.pig.get_mortality_record', 'method' => 'post']) !!}
						{{-- FIX THIS --}}
						<div class="row">
							<div class="col s10 offset-s1">
								<div class="col s6">
									<select name="registrationid_dead" class="browser-default">
										<option disabled selected>Choose pig</option>
										@foreach($breeders as $breeder)	
											<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
										@endforeach
									</select>
								</div>
								<div class="col s6">
									<input id="date_died" type="text" placeholder="Date Died" name="date_died" class="datepicker">
								</div>
							</div>
						</div>
						<div class="row center">
							<button class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}
          </div>
				</div>
			</div>
		</div>
	</div>
@endsection