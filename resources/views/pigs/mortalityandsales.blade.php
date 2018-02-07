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
						<ul class="tabs tabs-fixed-width red darken-4">
							<li class="tab col s4"><a href="#mortality_tab">Mortality</a></li>
							<li class="tab col s4"><a href="#sales_tab">Sales</a></li>
							<li class="tab col s4"><a href="#others_tab">Others</a></li>
						</ul>
					</div>
					<div id="mortality_tab" class="col s12">
						<div class="row">
							<div class="col s6">
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
						{!! Form::open(['route' => 'farm.pig.get_mortality_record', 'method' => 'post']) !!}
						<div class="row">
							<div class="col s10 offset-s1">
								{{ csrf_field() }}
								<div class="col s4">
									<select name="registrationid_dead" class="browser-default">
										<option disabled selected>Choose pig</option>
										@foreach($breeders as $breeder)	
											<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
										@endforeach
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
							<button id="add_dead" class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}	
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr class="red darken-4 white-text">
										<th>Registration ID</th>
										<th>Date of Death</th>
										<th>Cause of Death</th>
										<th>Age, months</th>
									</tr>
								</thead>
								<tbody>
									@forelse($dead as $dead_pig)
										<tr>
											<td>{{ $dead_pig->registryid }}</td>
											<td>{{ $dead_pig->getAnimalProperties()->where("property_id", 55)->first()->value }}</td>
											<td>{{ $dead_pig->getAnimalProperties()->where("property_id", 71)->first()->value }}</td>
											<td>{{ $dead_pig->getAge($dead_pig->id) }}</td>
										</tr>
									@empty
										<tr>
											<td>No mortality data found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
          </div>
					<div id="sales_tab" class="col s12">
						<div class="row">
							<div class="col s6">
								<select name="month_sales" class="browser-default">
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
										@foreach($breeders as $breeder)	
											<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
										@endforeach
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
              <button id="add_sold" class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr class="red darken-4 white-text">
										<th>Registration ID</th>
										<th>Date Sold</th>
										<th>Weight, kg</th>
										<th>Age, months</th>
									</tr>
								</thead>
								<tbody>
									@forelse($sold as $pig_sold)
										<tr>
											<td>{{ $pig_sold->registryid }}</td>
											<td>{{ $pig_sold->getAnimalProperties()->where("property_id", 56)->first()->value }}</td>
											<td>{{ $pig_sold->getAnimalProperties()->where("property_id", 57)->first()->value }}</td>
											<td>{{ $pig_sold->getAge($pig_sold->id) }}</td>
										</tr>
									@empty
										<tr>
											<td>No sales record found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
          </div>
          <div id="others_tab" class="col s12">
						<div class="row">
							<div class="col s6">
								<select name="month_others" class="browser-default">
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
										@foreach($breeders as $breeder)	
											<option value="{{ $breeder->registryid }}">{{ $breeder->registryid }}</option>
										@endforeach
									</select>
								</div>
								<div class="col s4">
									<input id="date_removed" type="text" placeholder="Date Removed" name="date_removed" class="datepicker">
								</div>
								<div class="col s4">
									<select name="reason_removed" class="browser-default">
										<option disabled selected>Choose reason</option>
										<option value="Culled">Culled</option>
										<option value="Representation">Representation</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row center">
							<button id="add_dead" class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}	
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr class="red darken-4 white-text">
										<th>Registration ID</th>
										<th>Date Removed</th>
										<th>Reason</th>
										<th>Age, months</th>
									</tr>
								</thead>
								<tbody>
									@forelse($removed as $removed_pig)
										<tr>
											<td>{{ $removed_pig->registryid }}</td>
											<td>{{ $removed_pig->getAnimalProperties()->where("property_id", 72)->first()->value }}</td>
											<td>{{ $removed_pig->getAnimalProperties()->where("property_id", 73)->first()->value }}</td>
											<td>{{ $removed_pig->getAge($removed_pig->id) }}</td>
										</tr>
									@empty
										<tr>
											<td>No removed pig data found</td>
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