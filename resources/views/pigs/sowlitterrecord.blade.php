@extends('layouts.swinedefault')

@section('title')
	Sow-Litter Record
@endsection

@section('content')
	<h4 class="headline">Sow-Litter Record</h4>
	<div class="container">
    <form class="row">
			<div class="col s12">
				<div class="row center">
					<div class="col s12 card-panel red darken-4 white-text">
						<div class="input-field col s3 push-s2">
							Sow ID
							<input placeholder="Search Sow" id="sowid" type="text" class="validate">
						</div>
						<div class="input-field col s3 push-s4">
							Boar ID
							<input placeholder="Search Boar" id="boarid" type="text" class="validate">
						</div>
					</div>
				</div>
				<div class="row center">
					<div class="col s12">
						<div class="row">
							<div class="col s8">
								<div class="row" style="padding-top:10px;">
									<div class="col s12">
										<table class="centered striped">
											<thead>
												<tr class="red darken-4 white-text">
													<th>Offspring ID</th>
													<th>Sex</th>
													<th>Birth weight, kg</th>
													<th>Weaning weight, kg</th>
													<th>Remarks</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>3000</td>
													<td>F</td>
													<td>10</td>
													<td>20</td>
													<td>...</td>
												</tr>
												<tr>
													<td>...</td>
													<td>...</td>
													<td>...</td>
													<td>...</td>
													<td>...</td>
												</tr>
												<tr>
													<td>...</td>
													<td>...</td>
													<td>...</td>
													<td>...</td>
													<td>...</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<h5 class="red darken-4 white-text">Add offspring</h5>
										<div class="input-field col s4">
                      <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate">
                      <label for="offspring_earnotch">Offspring Earnotch</label>
										</div>
										<div class="input-field col s4">
											<input id="sex" type="text" name="sex" class="validate">
											<label for="sex">Sex (M/F)</label>
										</div>
										<div class="input-field col s4">
											<input id="remarks" type="text" name="remarks" class="validate">
											<label for="remarks">Remarks</label>
										</div>
										<div class="input-field col s6">
											<input id="birth_weight" type="text" name="birth_weight">
											<label for="birth_weight">Birth Weight, kg</label>
										</div>
										<div class="input-field col s6">
											<input id="weaning_weight" type="text" name="weaning_weight">
											<label for="weaning_weight">Weaning Weight, kg</label>
										</div>
										<a href="#!" class="btn red lighten-2 waves-light waves-effect"><i class="material-icons right">add</i>Add</a>
									</div>
								</div>
							</div>
							<div class="col s4">
								<div class="card-panel red darken-4">
									<ul class="collection with-header">
										<li class="collection-header">Date Bred</li>
										<li class="collection-item">
											<div class="input-field">
												<input id="date_bred" type="text" placeholder="Pick date" name="date_bred" class="datepicker">
											</div>
										</li>
									</ul>
									<ul class="collection with-header">
										<li class="collection-header">Date Farrowed</li>
										<li class="collection-item">
											<div class="input-field">
												<input id="date_farrowed" type="text" placeholder="Pick date" name="date_farrowed" class="datepicker">
											</div>
										</li>
									</ul>
									<ul class="collection with-header">
										<li class="collection-header">Date Weaned</li>
										<li class="collection-item">
											<div class="input-field">
												<input id="date_weaned" type="text" placeholder="Pick date" name="date_weaned" class="datepicker">
											</div>
										</li>
									</ul>
								</div>
							</div>
            </div>
						<div class="row center">
							<button class="btn waves-effect waves-light red lighten-2" type="submit">Save
		            <i class="material-icons right">save</i>
		          </button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection