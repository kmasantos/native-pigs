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
						<table class="centered striped">
							<thead>
								<tr class="green lighten-1">
									<th>Sow ID</th>
									<th>Boar ID</th>
									<th>Date Bred</th>
									<th>Expected Date of Farrowing</th>
									<th>Recycled</th>
									<th>Status</th>
									<th>Sow-Litter Record</th>
								</tr>
							</thead>
							<tbody>
								@forelse($family as $breedingRecord)
									<tr>
										<td>
											{{ $breedingRecord->getMother()->registryid }} 
										</td>
										<td>
											{{ $breedingRecord->getFather()->registryid }}
										</td>
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
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 51)->first()))
											<td></td>
										@else
											<td>
												@if($breedingRecord->getGroupingProperties()->where("property_id", 51)->first()->value == 0)
													No
												@else
													Yes
												@endif
											</td>
										@endif
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 50)->first()))
											<td></td>
										@else
											<td>
												@if($breedingRecord->members == 0)
													{{ $breedingRecord->getGroupingProperties()->where("property_id", 50)->first()->value }}
												@else
													Farrowed
												@endif
											</td>
										@endif
										@if(is_null($breedingRecord->getGroupingProperties()->where("property_id", 51)->first()))
											<td></td>
										@else
											@if($breedingRecord->getGroupingProperties()->where("property_id", 51)->first()->value == 0)
												@if($breedingRecord->members == 0)
													<td>
														<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}"><i class="material-icons">add_circle_outline</i></a>
													</td>
												@else
													<td>
														<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}"><i class="material-icons">done</i></a>
													</td>
												@endif
											@else
												<td>
													<i class="material-icons">refresh</i>
												</td>
											@endif
										@endif
									</tr>
								@empty
									<tr>
										<td colspan="7">No mating record found</td>
									</tr>
								@endforelse
                {!! Form::open(['route' => 'farm.pig.get_breeding_record', 'method' => 'post']) !!}
								<tr>
									<td>
										<select name="sow_id" class="browser-default">
											<option disabled selected>Choose sow</option>
											<optgroup label="Breeders">
												@foreach($sows as $sow)	
													<option value="{{ $sow->registryid }}">{{ $sow->registryid }}</option>
												@endforeach
											</optgroup>
											<optgroup label="Growers">
												@foreach($femalegrowers as $femalegrower)
													<option value="{{ $femalegrower->registryid }}">{{ $femalegrower->registryid }}</option>
												@endforeach
											</optgroup>
										</select>
									</td>
									<td>
										<select id="boar_id" name="boar_id" class="browser-default">
											<option disabled selected>Choose boar</option>
											<optgroup label="Breeders">
												@foreach($boars as $boar)
													<option value="{{ $boar->registryid }}">{{ $boar->registryid }}</option>
												@endforeach
											</optgroup>
											<optgroup label="Growers">
												@foreach($malegrowers as $malegrower)
													<option value="{{ $malegrower->registryid }}">{{ $malegrower->registryid }}</option>
												@endforeach
											</optgroup>
										</select>
									</td>
									<td class="input-field">
										<input id="date_bred" type="text" placeholder="Pick date" name="date_bred" class="datepicker">
									</td>
									<td>
										{{-- <input disabled id="expected_date_of_farrowing" type="text" name="expected_date_of_farrowing" class="datepicker"> --}}
									</td>
									<td class="switch">
										<label>
											<input type="checkbox" id="recycled" name="recycled" onchange="disableField()">
											<span class="lever"></span>
										</label>
									</td>
									<td>
										{{-- <input disabled id="mating_status" type="text" name="mating_status" class="datepicker"> --}}
									</td>
									<td>
										
									</td>
								</tr>
              </tbody>
						</table>
					</div>
				</div>
				<div class="row center">
					<button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully added!', 4000)">Add
            <i class="material-icons right">add</i>
          </button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
  </div>
@endsection