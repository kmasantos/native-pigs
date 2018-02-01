@extends('layouts.swinedefault')

@section('title')
	Sow-Litter Record
@endsection

@section('content')
	<h4 class="headline">Sow-Litter Record</h4>
	<div class="container">
		{!! Form::open(['route' => 'farm.pig.get_sowlitter_record', 'method' => 'post']) !!}
    <div class="row">
			<div class="col s12">
				<div class="row center">
					<div class="col s12">
						<div class="col s3 push-s2">
							<select name="sow_id" class="browser-default red darken-4 white-text">
								<option disabled selected>Sow Used</option>
								@foreach($sows as $sow)
									<option id="{{ $sow->registryid }}" value="{{ $sow->registryid }}">{{ $sow->registryid }}</option>
								@endforeach
							</select>
						</div>
						<div class="col s3 push-s4">
							<select name="boar_id" class="browser-default red darken-4 white-text">
								<option disabled selected>Boar Used</option>
								@foreach($boars as $boar)
									<option id="{{ $boar->registryid }}" value="{{ $boar->registryid }}">{{ $boar->registryid }}</option>
								@endforeach
							</select>
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
												@forelse($offsprings as $offspring)
													<tr>
														<td>{{ $offspring->getChild()->registryid }}</td>
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 27)->first()->value }}</td>
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 53)->first()->value }}</td>
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 54)->first()->value }}</td>
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 52)->first()->value }}</td>
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
								<div class="row">
									<div class="col s12">
										<h5 class="red darken-4 white-text">Add offspring</h5>
										<input type="hidden" name="sow_registryid" value="{{ $sow->registryid }}">
										<div class="input-field col s4">
                      <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate">
                      <label for="offspring_earnotch">Offspring Earnotch</label>
										</div>
										<div class="input-field col s4">
											<input id="sex" type="text" name="sex" class="validate">
											<label for="sex">Sex (M/F)</label>
										</div>
										<div class="input-field col s4">
											<input id="litter_remarks" type="text" name="remarks" class="validate">
											<label for="litter_remarks">Remarks</label>
										</div>
										<div class="input-field col s6">
											<input id="birth_weight" type="text" name="birth_weight">
											<label for="birth_weight">Birth Weight, kg</label>
										</div>
										<div class="input-field col s6">
											<input id="weaning_weight" type="text" name="weaning_weight">
											<label for="weaning_weight">Weaning Weight, kg</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col s4">
								<div class="card-panel red darken-4">
									<ul class="collection">
										<li class="collection-item">
											<div class="input-field">
												<input disabled id="date_bred" type="text" name="date_bred" {{-- value="" --}}>
												<label for="date_bred">Date Bred</label>
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
		</div>
		{!! Form::close() !!}
	</div>
@endsection