@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales
@endsection

@section('content')
	<div class="container">
		<h4>Mortality and Sales</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
      <div class="col s12">
				<div class="row">
					<div class="col s12">
						<ul class="tabs tabs-fixed-width green lighten-1">
							<li class="tab"><a href="#mortality_tab">Mortality</a></li>
							<li class="tab"><a href="#sales_tab">Sales</a></li>
							<li class="tab"><a href="#others_tab">Others</a></li>
						</ul>
					</div>
					<div id="mortality_tab" class="col s12" style="padding-top: 10px;">
						{!! Form::open(['route' => 'farm.pig.get_mortality_record', 'method' => 'post']) !!}
						<div class="row">
							<div class="col s10 offset-s1">
								{{ csrf_field() }}
								<div class="col s4">
									<select name="registrationid_dead" class="browser-default">
										<option disabled selected>Choose pig</option>
										<optgroup label="Breeders">
											@foreach($breeders as $breeder)
												<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
											@endforeach
										</optgroup>
										<optgroup label="Growers">
											@foreach($growers as $grower)	
												<option value="{{ $grower->registryid }}">{{ $grower->registryid }}</option>
											@endforeach
										</optgroup>
									</select>
								</div>
								<div class="col s4">
									<input id="date_died" type="text" placeholder="Date Died" name="date_died" class="datepicker">
								</div>
								<div class="col s4">
									<input id="cause_death" type="text" placeholder="Cause of Death" name="cause_death">
								</div>
							</div>
						</div>
						<div class="row center">
							<button id="add_dead" class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully addded!', 4000)">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}	
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr class="green lighten-1">
										<th>Registration ID</th>
										<th>Date of Death</th>
										<th>Cause of Death</th>
										<th>Age</th>
									</tr>
								</thead>
								<tbody>
									@forelse($deadpigs as $deadpig)
										<tr>
											<td>{{ $deadpig->getRegistryId() }}</td>
											<td>{{ Carbon\Carbon::parse($deadpig->datedied)->format('j F, Y') }}</td>
											<td>{{ $deadpig->cause }}</td>
											@if($deadpig->age != "Age unavailable")
												@if(floor($deadpig->age/30) == 1)
													@if($deadpig->age % 30 == 1)
														<td>{{ floor($deadpig->age/30) }} month, {{ $deadpig->age % 30 }} day</td>
													@else
														<td>{{ floor($deadpig->age/30) }} month, {{ $deadpig->age % 30 }} days</td>
													@endif
												@else
													@if($deadpig->age % 30 == 1)
														<td>{{ floor($deadpig->age/30) }} months, {{ $deadpig->age % 30 }} day</td>
													@else
														<td>{{ floor($deadpig->age/30) }} months, {{ $deadpig->age % 30 }} days</td>
													@endif
												@endif
											@else
												<td>Age unavailable</td>
											@endif
										</tr>
									@empty
										<tr>
											<td colspan="4">No mortality data found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
          </div>
					<div id="sales_tab" class="col s12" style="padding-top: 10px;">
						{!! Form::open(['route' => 'farm.pig.get_sales_record', 'method' => 'post']) !!}
						<div class="row">
							<div class="col s10 offset-s1">
								{{ csrf_field() }}
								<div class="col s3">
									<select name="registrationid_sold" class="browser-default">
										<option disabled selected>Choose pig</option>
										<optgroup label="Breeders">
											@foreach($breeders as $breeder)
												<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
											@endforeach
										</optgroup>
										<optgroup label="Growers">
											@foreach($growers as $grower)	
												<option value="{{ $grower->registryid }}">{{ $grower->registryid }}</option>
											@endforeach
										</optgroup>
									</select>
								</div>
								<div class="col s3">
									<input id="date_sold" type="text" placeholder="Date Sold" name="date_sold" class="datepicker">
								</div>
								<div class="col s3">
									<input id="weight_sold" type="text" placeholder="Weight sold, kg" name="weight_sold" class="validate" />
								</div>
								<div class="col s3">
									<input id="price" type="text" placeholder="Price sold, Php" name="price" class="validate" />
								</div>
							</div>
						</div>
						<div class="row center">
              <button id="add_sold" class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully addded!', 4000)">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr class="green lighten-1">
										<th>Registration ID</th>
										<th>Date Sold</th>
										<th>Weight, kg</th>
										<th>Price, Php</th>
										<th>Age</th>
									</tr>
								</thead>
								<tbody>
									@forelse($soldpigs as $soldpig)
										<tr>
											<td>{{ $soldpig->getRegistryId() }}</td>
											<td>{{ Carbon\Carbon::parse($soldpig->datesold)->format('j F, Y') }}</td>
											<td>{{ $soldpig->weight }}</td>
											<td>{{ $soldpig->price }}</td>
											@if($soldpig->age != "Age unavailable")
												@if(floor($soldpig->age/30) == 1)
													@if($soldpig->age % 30 == 1)
														<td>{{ floor($soldpig->age/30) }} month, {{ $soldpig->age % 30 }} day</td>
													@else
														<td>{{ floor($soldpig->age/30) }} month, {{ $soldpig->age % 30 }} days</td>
													@endif
												@else
													@if($soldpig->ages % 30 == 1)
														<td>{{ floor($soldpig->age/30) }} months, {{ $soldpig->age % 30 }} day</td>
													@else
														<td>{{ floor($soldpig->age/30) }} months, {{ $soldpig->age % 30 }} days</td>
													@endif
												@endif
											@else
												<td>Age unavailable</td>
											@endif
										</tr>
									@empty
										<tr>
											<td colspan="5">No sales record found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
          </div>
          <div id="others_tab" class="col s12" style="padding-top: 10px;">
						{!! Form::open(['route' => 'farm.pig.get_removed_animal_record', 'method' => 'post']) !!}
						<div class="row">
							<div class="col s10 offset-s1">
								{{ csrf_field() }}
								<div class="col s4">
									<select name="registrationid_removed" class="browser-default">
										<option disabled selected>Choose pig</option>
										<optgroup label="Breeders">
											@foreach($breeders as $breeder)
												<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
											@endforeach
										</optgroup>
										<optgroup label="Growers">
											@foreach($growers as $grower)	
												<option value="{{ $grower->registryid }}">{{ $grower->registryid }}</option>
											@endforeach
										</optgroup>
									</select>
								</div>
								<div class="col s4">
									<input id="date_removed" type="text" placeholder="Date Removed" name="date_removed" class="datepicker">
								</div>
								<div class="col s4">
									<input id="reason_removed" type="text" placeholder="Reason Removed" name="reason_removed" class="validate">
								</div>
							</div>
						</div>
						<div class="row center">
							<button id="add_dead" class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully addded!', 4000)">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}	
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr class="green lighten-1">
										<th>Registration ID</th>
										<th>Date Removed</th>
										<th>Reason</th>
										<th>Age</th>
									</tr>
								</thead>
								<tbody>
									@forelse($removedpigs as $removedpig)
										<tr>
											<td>{{ $removedpig->getRegistryId() }}</td>
											<td>{{ Carbon\Carbon::parse($removedpig->dateremoved)->format('j F, Y') }}</td>
											<td>{{ $removedpig->reason }}</td>
											@if($removedpig->age != "Age unavailable")
												@if(floor($removedpig->age/30) == 1)
													@if($removedpig->age % 30 == 1)
														<td>{{ floor($removedpig->age/30) }} month, {{ $removedpig->age % 30 }} day</td>
													@else
														<td>{{ floor($removedpig->age/30) }} month, {{ $removedpig->age % 30 }} days</td>
													@endif
												@else
													@if($removedpig->age % 30 == 1)
														<td>{{ floor($removedpig->age/30) }} months, {{ $removedpig->age % 30 }} day</td>
													@else
														<td>{{ floor($removedpig->age/30) }} months, {{ $removedpig->age % 30 }} days</td>
													@endif
												@endif
											@else
												<td>Age unavailable</td>
											@endif
										</tr>
									@empty
										<tr>
											<td colspan="4">No removed pig data found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
          </div>
        </div>
      </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
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
	</script>
@endsection