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
						<div class="row">
							<div class="col s4">
								<select id="year_mortality" name="year_mortality" class="browser-default" onclick="filterMortality()">
									<option disabled selected>Choose year</option>
									@foreach($years as $year)
										<option value="{{ $year }}">{{ $year }}</option>
									@endforeach
								</select>
							</div>
							<div id="month_div_mortality" class="col s4" style="display:none;">
								<select id="month_mortality" name="month_mortality" class="browser-default">
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
									@forelse($dead as $dead_pig)
										<tr>
											<td>{{ $dead_pig->registryid }}</td>
											<td>{{ Carbon\Carbon::parse($dead_pig->getAnimalProperties()->where("property_id", 55)->first()->value)->format('j F, Y') }}</td>
											<td>{{ $dead_pig->getAnimalProperties()->where("property_id", 71)->first()->value }}</td>
											@if($dead_pig->getAge($dead_pig->id) != "")
												@if($dead_pig->getAge($dead_pig->id) != "Age unavailable")
													@if(floor($dead_pig->getAge($dead_pig->id)/30) == 1)
														@if($dead_pig->getAge($dead_pig->id) % 30 == 1)
															<td>{{ floor($dead_pig->getAge($dead_pig->id)/30) }} month, {{ $dead_pig->getAge($dead_pig->id) % 30 }} day</td>
														@else
															<td>{{ floor($dead_pig->getAge($dead_pig->id)/30) }} month, {{ $dead_pig->getAge($dead_pig->id) % 30 }} days</td>
														@endif
													@else
														@if($dead_pig->getAge($dead_pig->id) % 30 == 1)
															<td>{{ floor($dead_pig->getAge($dead_pig->id)/30) }} months, {{ $dead_pig->getAge($dead_pig->id) % 30 }} day</td>
														@else
															<td>{{ floor($dead_pig->getAge($dead_pig->id)/30) }} months, {{ $dead_pig->getAge($dead_pig->id) % 30 }} days</td>
														@endif
													@endif
												@else
													<td>Age unavailable</td>
												@endif
											@elseif($dead_pig->getAge($dead_pig->id) == 0)
												<td>0 months, 0 days</td>
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
						<div class="row">
							<div class="col s4">
								<select id="year_sales" name="year_sales" class="browser-default" onclick="filterSales()">
									<option disabled selected>Choose year</option>
									@foreach($years as $year)
										<option value="{{ $year }}">{{ $year }}</option>
									@endforeach
								</select>
							</div>
							<div id="month_div_sales" class="col s4" style="display:none;">
								<select id="month_sales" name="month_sales" class="browser-default">
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
						{!! Form::open(['route' => 'farm.pig.get_sales_record', 'method' => 'post']) !!}
						<div class="row">
							<div class="col s10 offset-s1">
								{{ csrf_field() }}
								<div class="col s4">
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
								<div class="col s4">
									<input id="date_sold" type="text" placeholder="Date Sold" name="date_sold" class="datepicker">
								</div>
								<div class="col s4">
									<input id="weight_sold" type="text" placeholder="Weight sold, kg" name="weight_sold" class="validate" />
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
										<th>Age</th>
									</tr>
								</thead>
								<tbody>
									@forelse($sold as $pig_sold)
										<tr>
											<td>{{ $pig_sold->registryid }}</td>
											<td>{{ Carbon\Carbon::parse($pig_sold->getAnimalProperties()->where("property_id", 56)->first()->value)->format('j F, Y') }}</td>
											@if(!is_null($pig_sold->getAnimalProperties()->where("property_id", 57)->first()))
												<td>{{ $pig_sold->getAnimalProperties()->where("property_id", 57)->first()->value }}</td>
											@else
												<td>Not specified</td>
											@endif
											@if($pig_sold->getAge($pig_sold->id) != "")
												@if($pig_sold->getAge($pig_sold->id) != "Age unavailable")
													@if(floor($pig_sold->getAge($pig_sold->id)/30) == 1)
														@if($pig_sold->getAge($pig_sold->id) % 30 == 1)
															<td>{{ floor($pig_sold->getAge($pig_sold->id)/30) }} month, {{ $pig_sold->getAge($pig_sold->id) % 30 }} day</td>
														@else
															<td>{{ floor($pig_sold->getAge($pig_sold->id)/30) }} month, {{ $pig_sold->getAge($pig_sold->id) % 30 }} days</td>
														@endif
													@else
														@if($pig_sold->getAge($pig_sold->id) % 30 == 1)
															<td>{{ floor($pig_sold->getAge($pig_sold->id)/30) }} months, {{ $pig_sold->getAge($pig_sold->id) % 30 }} day</td>
														@else
															<td>{{ floor($pig_sold->getAge($pig_sold->id)/30) }} months, {{ $pig_sold->getAge($pig_sold->id) % 30 }} days</td>
														@endif
													@endif
												@else
													<td>Age unavailable</td>
												@endif
											@elseif($pig_sold->getAge($pig_sold->id) == 0)
												<td>0 months, 0 days</td>
											@else
												<td>Age unavailable</td>
											@endif
										</tr>
									@empty
										<tr>
											<td colspan="4">No sales record found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
          </div>
          <div id="others_tab" class="col s12" style="padding-top: 10px;">
						<div class="row">
							<div class="col s4">
								<select id="year_removed" name="year_removed" class="browser-default" onclick="filterRemoved()">
									<option disabled selected>Choose year</option>
									@foreach($years as $year)
										<option value="{{ $year }}">{{ $year }}</option>
									@endforeach
								</select>
							</div>
							<div id="month_div_removed" class="col s4" style="display:none;">
								<select id="month_removed" name="month_removed" class="browser-default">
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
									<select name="reason_removed" class="browser-default">
										<option disabled selected>Choose reason</option>
										<option value="Representation">Donated</option>
									</select>
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
									@forelse($removed as $removed_pig)
										<tr>
											<td>{{ $removed_pig->registryid }}</td>
											<td>{{ Carbon\Carbon::parse($removed_pig->getAnimalProperties()->where("property_id", 72)->first()->value)->format('j F, Y') }}</td>
											<td>{{ $removed_pig->getAnimalProperties()->where("property_id", 73)->first()->value }}</td>
											@if($removed_pig->getAge($removed_pig->id) != "")
												@if($removed_pig->getAge($removed_pig->id) != "Age unavailable")
													@if(floor($removed_pig->getAge($removed_pig->id)/30) == 1)
														@if($removed_pig->getAge($removed_pig->id) % 30 == 1)
															<td>{{ floor($removed_pig->getAge($removed_pig->id)/30) }} month, {{ $removed_pig->getAge($removed_pig->id) % 30 }} day</td>
														@else
															<td>{{ floor($removed_pig->getAge($removed_pig->id)/30) }} month, {{ $removed_pig->getAge($removed_pig->id) % 30 }} days</td>
														@endif
													@else
														@if($removed_pig->getAge($removed_pig->id) % 30 == 1)
															<td>{{ floor($removed_pig->getAge($removed_pig->id)/30) }} months, {{ $removed_pig->getAge($removed_pig->id) % 30 }} day</td>
														@else
															<td>{{ floor($removed_pig->getAge($removed_pig->id)/30) }} months, {{ $removed_pig->getAge($removed_pig->id) % 30 }} days</td>
														@endif
													@endif
												@else
													<td>Age unavailable</td>
												@endif
											@elseif($removed_pig->getAge($removed_pig->id) == 0)
												<td>0 months, 0 days</td>
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