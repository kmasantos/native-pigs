@extends('layouts.swinedefault')

@section('title')
	Sales Record
@endsection

@section('content')
	<h4 class="headline">Sales Record</h4>
	<div class="container">
		<div class="row">
      <div class="col s12">
				<div class="row">
					<div class="col s12">
						<div class="row">
							<div class="col s4">
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
											<td>{{ $pig_sold->getAnimalProperties()->where("property_id", 56)->first()->value }}</td>
											<td>{{ $pig_sold->getAnimalProperties()->where("property_id", 57)->first()->value }}</td>
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