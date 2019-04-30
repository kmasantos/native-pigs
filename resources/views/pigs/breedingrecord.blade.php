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
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								{!! Form::open(['route' => 'farm.pig.get_breeding_record', 'method' => 'post']) !!}
								<tr>
									{{-- sow used --}}
									{{-- <td> 
										<select id="sow_id" name="sow_id" class="browser-default">
											<option disabled selected>Choose sow</option>
												@foreach($available as $sow)	
													<option value="{{ $sow }}">{{ $sow }}</option>
												@endforeach
										</select>
									</td> --}}
									<td> 
										<select id="sow_id" name="sow_id" class="browser-default" required>
											<option value=""></option>
												@foreach($sows as $sow)	
													<option value="{{ $sow->registryid }}">{{ $sow->registryid }}</option>
												@endforeach
										</select>
										<label for="sow_id">Choose sow</label>
									</td>
									{{-- boar used --}}
									<td>
										<select id="boar_id" name="boar_id" class="browser-default" required>
											<option value=""></option>
												@foreach($boars as $boar)
													<option value="{{ $boar->registryid }}">{{ $boar->registryid }}</option>
												@endforeach
										</select>
										<label for="boar_id">Choose boar</label>
									</td>
									{{-- date bred --}}
									<td class="input-field">
										<input id="date_bred" type="text" placeholder="Pick date" name="date_bred" class="datepicker" required>
									</td>
									{{-- submit button --}}
									<td colspan="4" class="center">
										<button class="btn waves-effect waves-light green darken-3 tooltipped" data-position="top" data-tooltip="Add breeding record" type="submit">
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
												<strong>{{ $breedingRecord->getMother()->registryid }}</strong> <p><sup>(Dead)</sup></p>
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
												<strong>{{ $breedingRecord->getFather()->registryid }}</strong> <p><sup>(Dead)</sup></p>
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
											<td width="120">
												{{ $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value }}
											</td>
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
													<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add Sow & Litter Record"><i class="material-icons">add_circle_outline</i></a>
												</td>
											{{-- farrowed --}}
											@elseif($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Farrowed")
												<td>
													<a href="{{ URL::route('farm.pig.sowlitter_record', [$breedingRecord->id]) }}" class="tooltipped" data-position="top" data-tooltip="View Sow & Litter Record"><i class="material-icons">done</i></a>
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
										{{-- edit button --}}
										<td>
											@if($breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Recycled" || $breedingRecord->getGroupingProperties()->where("property_id", 60)->first()->value == "Aborted")
												<i class="material-icons tooltipped" data-position="top" data-tooltip="Cannot be edited">clear</i>
											@else
												<a href="{{ URL::route('farm.pig.edit_breeding_record', [$breedingRecord->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
											@endif
										</td>
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
		{{-- @if($archived_records == [])
    @else --}}
      <div class="row">
        <div class="col s12">
          <ul class="collapsible popout">
            <li>
              <div class="collapsible-header grey lighten-2">Archive</div>
              <div class="collapsible-body">
                <table class="fixed-width">
                  <thead>
                    <tr>
                      <th>Sow Used</th>
                      <th>Boar Used</th>
                      <th>Date Bred</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    	<td><a href="#!"><i class="material-icons">visibility_on</i></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </li>
          </ul>
        </div>
      </div>
    {{-- @endif --}}
  </div>
@endsection

@section('scripts')
	<script type="text/javascript">
			$('#<?php echo $breedingRecord->id ?>').pickadate({
				format: 'yyyy-mm-dd',
				min: new Date(<?php echo Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(18)->format('Y') ?>, <?php echo Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(18)->format('m')-1 ?>, <?php echo Carbon\Carbon::parse($breedingRecord->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(18)->format('d') ?>),
				max: new Date()
			});
			$('.datepicker').pickadate({
			  selectMonths: true, // Creates a dropdown to control month
			  selectYears: 15, // Creates a dropdown of 15 years to control year,
			  today: 'Today',
			  clear: 'Clear',
			  close: 'Ok',
			  closeOnSelect: false, // Close upon selecting a date,
			  format: 'yyyy-mm-dd', 
			  max: new Date()
			});
	</script>
@endsection