@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales
@endsection

@section('content')
	<h4 class="headline">Mortality and Sales</h4>
	<div class="container">
		<form class="row">
      <div class="col s12">
				<div class="row">
					<div class="col s12">
						<ul class="tabs tabs-fixed-width red darken-4">
							<li class="tab col s6"><a href="#mortality_tab">Mortality</a></li>
							<li class="tab col s6"><a href="#sales_tab">Sales</a></li>
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
											<td>Month DD, YYYY</td>
											<td>XX</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						{!! Form::open(['route' => 'farm.pig.get_mortality_record', 'method' => 'POST']) !!}
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
							<button id="add_dead" class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
						{!! Form::close() !!}
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
						<div class="row">
							<table class="centered striped">
								<thead>
									<tr>
										<th>Registration ID</th>
										<th>Date Sold</th>
										<th>Weight, kg</th>
										<th>Age, months</th>
									</tr>
								</thead>
								<tbody>
									@foreach($sold as $pig_sold)
										<tr>
											<td>{{ $pig_sold->registryid }}</td>
											{{-- FETCH THESE PROPERLY --}}
											<td>{{ $salesproperties[3]->value }}</td>
											<td>{{ $salesproperties[4]->value }}</td>
											{{-- COMPUTE AGE --}}
											<td>X</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						{!! Form::open(['route' => 'farm.pig.get_sales_record', 'method' => 'post']) !!}
						<div class="row">
							<div class="col s10 offset-s1">
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
          </div>
        </div>
      </div>
		</form>
	</div>
@endsection