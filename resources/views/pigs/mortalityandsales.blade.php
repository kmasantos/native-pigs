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
							<li class="tab col s6"><a href="#tab1">Mortality</a></li>
							<li class="tab col s6"><a href="#tab2">Sales</a></li>
						</ul>
					</div>
					<div id="tab1" class="col s12">
						<div class="row">
							<div class="input-field col s6">
								<select id="month_mortality">
									<option value="" disabled selected>Choose month</option>
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
								<label for="month_mortality">Month</label>
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
									<tr>
										<td>QUEBAIBP-20161F1000</td>
										<td>Month DD, YYYY</td>
										<td>XX</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col s10 offset-s1">
								<div class="input-field col s6">
									<input id="registration_id" type="text" name="registration_id" class="validate" />
									<label for="registration_id">Registration ID</label>
								</div>
								<div class="input-field col s6">
									<input id="date_bred" type="text" placeholder="Date Died" name="date_bred" class="datepicker">
								</div>
							</div>
						</div>
						<div class="row center">
							<button class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
          </div>
					<div id="tab2" class="col s12">
						<div class="row">
							<div class="input-field col s6">
								<select id="month_sales">
									<option value="" disabled selected>Choose month</option>
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
								<label for="month_sales">Month</label>
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
									<tr>
										<td>QUEBAIBP-20161M2000</td>
										<td>Month DD, YYYY</td>
										<td>XX</td>
										<td>X</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col s10 offset-s1">
								<div class="input-field col s4">
									<input id="registration_id" type="text" name="registration_id" class="validate" />
									<label for="registration_id">Registration ID</label>
								</div>
								<div class="input-field col s4">
									<input id="date_bred" type="text" placeholder="Date Sold" name="date_bred" class="datepicker">
								</div>
								<div class="input-field col s4">
									<input id="weight_sold" type="text" name="weight_sold" class="validate" />
									<label for="weight_sold">Weight sold, kg</label>
								</div>
							</div>
						</div>
						<div class="row center">
              <button class="btn waves-effect waves-light red lighten-2" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
						</div>
          </div>
        </div>
      </div>
		</form>
	</div>
@endsection