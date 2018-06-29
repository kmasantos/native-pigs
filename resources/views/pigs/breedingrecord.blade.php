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
									<th>Sow ID</th>
									<th>Boar ID</th>
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
												<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Died {{ Carbon\Carbon::parse($breedingRecord->getMother()->getAnimalProperties()->where("property_id", 55)->first()->value)->format('F j, Y') }})</sup></p>
											</td>
										@elseif($breedingRecord->getMother()->status == "sold grower" || $breedingRecord->getMother()->status == "sold breeder")
											<td>
												<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Sold {{ Carbon\Carbon::parse($breedingRecord->getMother()->getAnimalProperties()->where("property_id", 56)->first()->value)->format('F j, Y') }})</sup></p>
											</td>
										@elseif($breedingRecord->getMother()->status == "removed grower" || $breedingRecord->getMother()->status == "removed breeder")
											@if($breedingRecord->getMother()->getAnimalProperties()->where("property_id", 73)->first()->value == "Donated")
												<td>
													<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Donated {{ Carbon\Carbon::parse($breedingRecord->getMother()->getAnimalProperties()->where("property_id", 72)->first()->value)->format('F j, Y') }})</sup></p>
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
												<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Died {{ Carbon\Carbon::parse($breedingRecord->getFather()->getAnimalProperties()->where("property_id", 55)->first()->value)->format('F j, Y') }})</sup></p>
											</td>
										@elseif($breedingRecord->getFather()->status == "sold grower" || $breedingRecord->getFather()->status == "sold breeder")
											<td>
												<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Sold {{ Carbon\Carbon::parse($breedingRecord->getFather()->getAnimalProperties()->where("property_id", 56)->first()->value)->format('F j, Y') }})</sup></p>
											</td>
										@elseif($breedingRecord->getFather()->status == "removed grower" || $breedingRecord->getFather()->status == "removed breeder")
											@if($breedingRecord->getFather()->getAnimalProperties()->where("property_id", 73)->first()->value == "Donated")
												<td>
													<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Donated {{ Carbon\Carbon::parse($breedingRecord->getFather()->getAnimalProperties()->where("property_id", 72)->first()->value)->format('F j, Y') }})</sup></p>
												</td>
											@endif
										@endif
										{{-- date bred --}}
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 48)->first()))
											<td></td>
										@else
											<td>
												{{ Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 48)->first()->value)->format('j F, Y') }}
											</td>
										@endif
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 49)->first()))
											<td></td>
										@else
											<td>
												{{ Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 49)->first()->value)->format('j F, Y') }}
											</td>
										@endif
										{{-- status --}}
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()))
											<td></td>
										@else
											{{-- bred --}}
											@if($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Bred")
												{!! Form::open(['route' => ['farm.pig.change_status_bred', $breedingRecord->id], 'method' => 'post', 'id' => 'bred_change']) !!}
												<td width="120">
													<select id="status_bred" name="mating_status" class="browser-default" onchange="document.getElementById('bred_change').submit();">
														<option disabled selected>{{ $breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value }}</option>
														<option value="Pregnant">Pregnant</option>
														<option value="Recycled">Recycled</option>
													</select>
												</td>
												{!! Form::close() !!}
											{{-- pregnant --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Pregnant")
												{!! Form::open(['route' => ['farm.pig.change_status_pregnant', $breedingRecord->id], 'method' => 'post', 'id' => 'pregnant_change']) !!}
												<td width="120">
													<select id="status_pregnant" name="mating_status" class="browser-default" onchange="document.getElementById('pregnant_change').submit();">
														<option disabled selected>{{ $breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value }}</option>
														<option value="Farrowed">Farrowed</option>
														<option value="Aborted">Aborted</option>
													</select>
												</td>
												{!! Form::close() !!}
											{{-- recycled/aborted/farrowed --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Recycled" || $breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Farrowed" || $breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Aborted")
												<td>{{ $breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value }}</td>
											@endif
										@endif
										{{-- icons --}}
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()))
											<td></td>
										@else
											{{-- bred --}}
											@if($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Bred")
												<td>
													<i class="material-icons">favorite_border</i>
												</td>
											{{-- pregnant --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Pregnant")
												<td>
													<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}"><i class="material-icons">add_circle_outline</i></a>
												</td>
											{{-- farrowed --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Farrowed")
												<td>
													<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}"><i class="material-icons">done</i></a>
												</td>
											{{-- recycled --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Recycled")
												<td>
													<i class="material-icons">refresh</i>
												</td>
											{{-- aborted --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value == "Aborted")
												@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 89)->first()))
													{!! Form::open(['route' => 'farm.pig.add_date_aborted', 'method' => 'post', 'id' => 'add_dateaborted']) !!}
														<td class="input-field" width="120">
															<input id="date_aborted" type="text" placeholder="Date Aborted" name="date_aborted" class="datepicker" onchange="document.getElementById('add_dateaborted').submit();">
														</td>
													{!! Form::close() !!}
												@else
													<td width="120">
														Date Aborted: {{ Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 89)->first()->value)->format('j F, Y') }}
													</td>
												@endif
											@endif
										@endif
									</tr>
								@empty
									<tr>
										<td colspan="6">No mating record found</td>
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