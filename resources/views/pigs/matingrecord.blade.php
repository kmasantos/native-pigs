@extends('layouts.swinedefault')

@section('title')
	Mating Record
@endsection

@section('content')
	<h4 class="headline">Mating Record</h4>
	<div class="container">
		<div class="row">
			<div class="col s12">
				<div class="row">
					<div class="input-field col s4">
						<select id="month_mating">
							<option value="" disabled selected>Choose month</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<label for="month_mating">Month</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<table class="centered striped responsive-table">
							<thead>
								<tr class="red darken-4 white-text">
									<th>Sow ID</th>
									<th>Boar ID</th>
									<th>Date Bred</th>
									<th>Expected Date of Farrowing</th>
									<th>Date Pregnant</th>
									<th>Recycled</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										QUEBAIBP-20161F1000
									</td>
									<td>
										QUEBAIBP-20161M2000
									</td>
									<td>
										Month DD, YYYY
									</td>
									<td>
										Month DD, YYYY
									</td>
									<td>
										Month DD, YYYY
									</td>
									<td>
										No
									</td>
								</tr>
								<tr>
									<td>
										QUEBAIBP-20161F1001
									</td>
									<td>
										QUEBAIBP-20161M2001
									</td>
									<td>
										Month DD, YYYY
									</td>
									<td>
										Month DD, YYYY
									</td>
									<td>
										Month DD, YYYY
									</td>
									<td>
										Yes
									</td>
                </tr>
                {!! Form::open(['route' => 'farm.pig.get_mating_record', 'method' => 'post']) !!}
								<tr>
									<td class="input-field">
										<input id="sow_id" type="text" placeholder="Sow Earnotch" name="sow_id" class="validate">
									</td>
									<td class="input-field">
										<input id="boar_id" type="text" placeholder="Boar Earnotch" name="boar_id" class="validate">
									</td>
									<td class="input-field">
										<input id="date_bred" type="text" placeholder="Pick date" name="date_bred" class="datepicker">
									</td>
									<td>
										<input id="expected_date_of_farrowing" type="text" placeholder="Pick date" name="expected_date_of_farrowing" class="datepicker">
									</td>
									<td>
										<input id="date_pregnant" type="text" placeholder="Pick date" name="date_pregnant" class="datepicker">
									</td>
									<td class="switch">
										<label>
											<input type="checkbox" name="recycled">
											<span class="lever"></span>
										</label>
									</td>
								</tr>
              </tbody>
						</table>
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
@endsection