@extends('layouts.swinedefault')

@section('title')
	Breeding Record
@endsection

@section('content')
	<div class="container">
		<h4>Breeding Record</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
			<div class="col s12">
				<div class="row">
					<div class="col s4">
						<select id="year_mating" name="year_mating" class="browser-default" onclick="filterBreedingRecord()">
							<option disabled selected>Choose year</option>
							@foreach($years as $year)
								<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select>
					</div>
					<div id="month_div_breeding" class="col s4" style="display:none;">
						<select id="month_mating" name="month_mating" class="browser-default">
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
					<div class="col s12">
						<table class="centered responsive-table striped">
							<thead>
								<tr class="green lighten-1">
									<th>Sow Used</th>
									<th>Boar Used</th>
									<th>Date Bred</th>
									<th>Expected Date of Farrowing</th>
									<th>Status</th>
									<th>Sow & Litter Record</th>
								</tr>
							</thead>
							<tbody>
								{!! Form::open(['route' => 'farm.pig.get_breeding_record', 'method' => 'post']) !!}
								<tr>
									{{-- sow used --}}
									<td> 
										<select name="sow_id" class="browser-default">
											<option disabled selected>Choose sow</option>
												@foreach($sows as $sow)	
													<option value="{{ $sow->registryid }}">{{ $sow->registryid }}</option>
												@endforeach
										</select>
									</td>
									{{-- boar used --}}
									<td>
										<select id="boar_id" name="boar_id" class="browser-default">
											<option disabled selected>Choose boar</option>
												@foreach($boars as $boar)
													<option value="{{ $boar->registryid }}">{{ $boar->registryid }}</option>
												@endforeach
										</select>
									</td>
									{{-- date bred --}}
									<td class="input-field">
										<input id="date_bred" type="text" placeholder="Pick date" name="date_bred" class="datepicker">
									</td>
									{{-- submit button --}}
									<td colspan="3" class="center">
										<button class="btn waves-effect waves-light green darken-3 tooltipped" data-position="top" data-tooltip="Add breeding record" type="submit" onclick="Materialize.toast('Successfully added!', 4000)">
											Add <i class="material-icons right">add</i>
					          </button>
									</td>
								</tr>
								{!! Form::close() !!}
								@forelse($family as $breedingRecord)
									<tr>
										{{-- sow used with status --}}
										@if($breedingRecord->getMother()->status == "active" || $breedingRecord->getMother()->status == "breeder")
											<td>
												<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Active)</sup></p>
											</td>
										@elseif($breedingRecord->getMother()->status == "dead grower" || $breedingRecord->getMother()->status == "dead breeder")
											<td>
												<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Died)</sup></p>
											</td>
										@elseif($breedingRecord->getMother()->status == "sold grower" || $breedingRecord->getMother()->status == "sold breeder")
											<td>
												<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Sold)</sup></p>
											</td>
										@elseif($breedingRecord->getMother()->status == "removed grower" || $breedingRecord->getMother()->status == "removed breeder")
											@if($breedingRecord->getMother()->status == "removed grower")
												<td>
													<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Donated)</sup></p>
												</td>
											@elseif($breedingRecord->getMother()->status == "removed breeder")
												<td>
													<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Culled)</sup></p>
												</td>
											@endif
										@endif
										{{-- boar used with status --}}
										@if($breedingRecord->getFather()->status == "active" || $breedingRecord->getFather()->status == "breeder")
											<td>
												<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Active)</sup></p>
											</td>
										@elseif($breedingRecord->getFather()->status == "dead grower" || $breedingRecord->getFather()->status == "dead breeder")
											<td>
												<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Died)</sup></p>
											</td>
										@elseif($breedingRecord->getFather()->status == "sold grower" || $breedingRecord->getFather()->status == "sold breeder")
											<td>
												<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Sold)</sup></p>
											</td>
										@elseif($breedingRecord->getFather()->status == "removed grower" || $breedingRecord->getFather()->status == "removed breeder")
											@if($breedingRecord->getFather()->status == "removed grower")
												<td>
													<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Donated)</sup></p>
												</td>
											@elseif($breedingRecord->getFather()->status = "removed breeder")
												<td>
													<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Culled)</sup></p>
												</td>
											@endif
										@endif
										{{-- date bred --}}
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 42)->first()))
											<td></td>
										@else
											<td>
												{{ Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 42)->first()->value)->format('j F, Y') }}
											</td>
										@endif
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 43)->first()))
											<td></td>
										@else
											<td>
												{{ Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 43)->first()->value)->format('j F, Y') }}
											</td>
										@endif
										{{-- status --}}
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()))
											<td></td>
										@else
											{{-- bred --}}
											@if($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Bred")
												{!! Form::open(['route' => ['farm.pig.change_status_bred', $breedingRecord->id], 'method' => 'post', 'id' => 'bred_change']) !!}
												<td width="120">
													{{ $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value }} <a href="#change_from_bred_modal{{ $breedingRecord->id }}" class="modal-trigger tooltipped" data-position="top" data-tooltip="Change status"><i class="material-icons right">swap_vert</i></a>
												</td>
												{{-- MODAL STRUCTURE --}}
												<div id="change_from_bred_modal{{ $breedingRecord->id }}" class="modal">
													<div class="modal-content">
														<h5 class="center">Current status: <strong>{{ $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value }}</strong></h5><br><br>
														<input type="hidden" name="grouping_id" value="{{ $breedingRecord->id }}">
														<div class="row">
															<div class="col s2 offset-s1">
																Change to:
															</div>
															<div class="col s4">
									              <input class="with-gap" name="change_status_bred" type="radio" id="change_status_bred_pregnant" value="Pregnant" />
									              <label for="change_status_bred_pregnant">Pregnant</label>
									            </div>
									            <div class="col s4">
									              <input class="with-gap" name="change_status_bred" type="radio" id="change_status_bred_recycled" value="Recycled" />
									              <label for="change_status_bred_recycled">Recycled</label>
									            </div>
									          </div>
									          <div class="row center">
									          	<button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Update
									              <i class="material-icons right">done</i>
									            </button>
									          </div>
													</div>
												</div>
												{!! Form::close() !!}
											{{-- pregnant --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Pregnant")
												{!! Form::open(['route' => ['farm.pig.change_status_pregnant', $breedingRecord->id], 'method' => 'post', 'id' => 'pregnant_change']) !!}
												<td width="120">
													{{ $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value }} <a href="#change_from_pregnant_modal{{ $breedingRecord->id }}" class="modal-trigger tooltipped" data-position="top" data-tooltip="Change status"><i class="material-icons right">swap_vert</i></a>
												</td>
												{{-- MODAL STRUCTURE --}}
												<div id="change_from_pregnant_modal{{ $breedingRecord->id }}" class="modal">
													<div class="modal-content">
														<h5 class="center">Current status: <strong>{{ $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value }}</strong></h5><br><br>
														<input type="hidden" name="grouping_id" value="{{ $breedingRecord->id }}">
														<div class="row">
															<div class="col s2 offset-s1">
																Change to:
															</div>
															<div class="col s4">
									              <input class="with-gap" name="change_status_pregnant" type="radio" id="change_status_pregnant_farrowed" value="Farrowed" />
									              <label for="change_status_pregnant_farrowed">Farrowed</label>
									            </div>
									            <div class="col s4">
									              <input class="with-gap" name="change_status_pregnant" type="radio" id="change_status_pregnant_aborted" value="Aborted" />
									              <label for="change_status_pregnant_aborted">Aborted</label>
									            </div>
									          </div>
									          <div class="row center">
									          	<button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Update
									              <i class="material-icons right">done</i>
									            </button>
									          </div>
													</div>
												</div>
												{!! Form::close() !!}
											{{-- recycled/aborted/farrowed --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Recycled" || $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Farrowed" || $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Aborted")
												<td>{{ $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value }}</td>
											@endif
										@endif
										{{-- icons --}}
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()))
											<td></td>
										@else
											{{-- bred --}}
											@if($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Bred")
												<td>
													<i class="material-icons">favorite_border</i>
												</td>
											{{-- pregnant --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Pregnant")
												<td>
													<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}"><i class="material-icons">add_circle_outline</i></a>
												</td>
											{{-- farrowed --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Farrowed")
												<td>
													<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}"><i class="material-icons">done</i></a>
												</td>
											{{-- recycled --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Recycled")
												<td>
													<i class="material-icons">refresh</i>
												</td>
											{{-- aborted --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Aborted")
												@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 44)->first()))
													{!! Form::open(['route' => 'farm.pig.add_date_aborted', 'method' => 'post', 'id' => 'add_dateaborted']) !!}
														<td class="input-field" width="120">
															<input type="hidden" name="group_id" value="{{ $breedingRecord->id }}">
															<input id="{{ $breedingRecord->id }}" type="text" placeholder="Date Aborted" name="date_aborted" class="datepicker" onchange="document.getElementById('add_dateaborted').submit();">
														</td>
													{!! Form::close() !!}
												@else
													<td width="120">
														Date Aborted: {{ Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 44)->first()->value)->format('j F, Y') }}
													</td>
												@endif
											@endif
										@endif
									</tr>
								@empty
									<tr>
										<td colspan="6">No breeding record found</td>
									</tr>
								@endforelse
              </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
  </div>
@endsection