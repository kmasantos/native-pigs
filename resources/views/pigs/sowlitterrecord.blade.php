@extends('layouts.swinedefault')

@section('title')
	Sow-Litter Record
@endsection

@section('content')
	<div class="container">
		{{-- <h4><a href="{{route('farm.pig.breeding_record')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Sow-Litter Record</h4> --}}
		<h4><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Sow-Litter Record</h4>
		<div class="divider"></div>
		{!! Form::open(['route' => 'farm.pig.get_sowlitter_record', 'method' => 'post']) !!}
    <div class="row">
    	<input type="hidden" name="grouping_id" value="{{ $family->id }}">
			<div class="col s12">
				<div class="row center">
					<div class="col s12">
						<div class="col s6 center">
							<h5>Sow used: {{ $family->getMother()->registryid }}</h5>
						</div>
						<div class="col s6 center">
							<h5>Boar used: {{ $family->getFather()->registryid }}</h5>
						</div>
					</div>
				</div>
				<div class="col s12 card-panel">
					<div class="row">
						<div class="col s6" style="padding-top: 10px;">
							{{-- GROUP PROPERTIES --}}
							<div class="row">

							</div>
							<div class="row">

							</div>
							<div class="row">

							</div>
							<div class="row">
								
							</div>
							<div class="row">
								
							</div>
							<div class="row">
								
							</div>
							<div class="row">
								
							</div>
							<div class="row">
								
							</div>
							<div class="row">
								<div class="col s6">
									Date Bred
								</div>
								<div class="col s6">
									{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 48)->first()->value)->format('j F, Y') }}
								</div>
							</div>
							<div class="row">
								@if(is_null($family->getGroupingProperties()->where("property_id", 25)->first()))
									<div class="col s6">
										<p>Date Farrowed</p>
									</div>
									<div class="col s6">
										<input id="date_farrowed" type="text" name="date_farrowed" placeholder="Pick date" class="datepicker">
									</div>
								@else
									<div class="col s6">
										Date Farrowed
									</div>
									<div class="col s6">
										{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 25)->first()->value)->format('j F, Y') }}
										<input id="hidden_date" type="hidden" name="date_farrowed" value="{{ $family->getGroupingProperties()->where("property_id", 25)->first()->value }}">
									</div>
								@endif
							</div>
							<div class="row">
								@if(!is_null($family->getGroupingProperties()->where("property_id", 25)->first()))
									@if(is_null($family->getGroupingProperties()->where("property_id", 61)->first()))
										<div class="col s6">
											<p>Date Weaned</p>
										</div>
										<div class="col s6">
											<input id="date_weaned" type="text" name="date_weaned" placeholder="Pick date" class="datepicker">
										</div>
									@else
										<div class="col s6">
											Date Weaned
										</div>
										<div class="col s6">
											{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 61)->first()->value)->format('j F, Y') }}
											<input id="hidden_weaned" type="hidden" name="date_weaned" value="{{ $family->getGroupingProperties()->where("property_id", 61)->first()->value }}">
										</div>
									@endif
								@else
									<div class="col s6">
										<p>Date Weaned</p>
									</div>
									<div class="col s6">
										<input disabled id="date_weaned" type="text" name="date_weaned" placeholder="Pick date" class="datepicker">
									</div>
								@endif
							</div>
						</div>
						<div class="col s6">
							{{-- COMPUTED VALUES --}}
							<div class="row">

							</div>
							<div class="row">
								<div class="col s8">
									<p>Parity</p>
								</div>
								<div class="col s4">
									@if(is_null($family->getGroupingProperties()->where("property_id", 25)->first()))
										@if(is_null($family->getGroupingProperties()->where("property_id", 76)->first()))
											<input id="paritytext" type="text" name="parity"> 
										@else
											<input id="paritytext" type="text" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 76)->first()->value }}">
										@endif
									@else
										@if(is_null($family->getGroupingProperties()->where("property_id", 76)->first()))
											<input id="paritytext" type="text" name="parity"> 
										@else
											<input id="paritytext" type="text" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 76)->first()->value }}">
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Total Littersize Born
								</div>
								<div class="col s4">
									@if($family->members == 1 && !is_null($family->getGroupingProperties()->where("property_id", 74)->first()) || !is_null($family->getGroupingProperties()->where("property_id", 75)->first()))
										{{ count($family->getGroupingMembers()) + $family->getGroupingProperties()->where("property_id", 74)->first()->value + $family->getGroupingProperties()->where("property_id", 75)->first()->value }}
									@elseif($family->members == 1 && (is_null($family->getGroupingProperties()->where("property_id", 74)->first()) && is_null($family->getGroupingProperties()->where("property_id", 75)->first())))
										{{ count($family->getGroupingMembers()) }}
									@elseif($family->members == 0 && (!is_null($family->getGroupingProperties()->where("property_id", 74)->first()) || !is_null($family->getGroupingProperties()->where("property_id", 75)->first())))
										{{ $family->getGroupingProperties()->where("property_id", 74)->first()->value + $family->getGroupingProperties()->where("property_id", 75)->first()->value }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Total Littersize Born Alive
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ count($family->getGroupingMembers()) }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Number weaned
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ $weaned }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Average birth weight
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ round($aveBirthWeight, 4) }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Number of males
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ $countMales }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Number of females
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ $countFemales }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Sex ratio (Male to Female)
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ $countMales.':'.$countFemales }}
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Average weaning weight
								</div>
								<div class="col s4">
									@if($family->members == 1)
										{{ round($aveWeaningWeight, 4) }}
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row center">
					<div class="col s6">
						@if(is_null($family->getGroupingProperties()->where("property_id", 25)->first()))
							@if(is_null($family->getGroupingProperties()->where("property_id", 74)->first()))
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn">
								</div>
							@else
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 74)->first()->value }}">
								</div>
							@endif
						@else
							@if(is_null($family->getGroupingProperties()->where("property_id", 74)->first()))
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn">
								</div>
							@else
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 74)->first()->value }}">
								</div>
							@endif
						@endif
					</div>
					<div class="col s6">
						@if(is_null($family->getGroupingProperties()->where("property_id", 25)->first()))
							@if(is_null($family->getGroupingProperties()->where("property_id", 75)->first()))
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified">
								</div>
							@else
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 75)->first()->value }}">
								</div>
							@endif
						@else
							@if(is_null($family->getGroupingProperties()->where("property_id", 75)->first()))
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified">
								</div>
							@else
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 75)->first()->value }}">
								</div>
							@endif
						@endif
					</div>
					<div class="col s12">
						<h5 class="green lighten-1">Add offspring</h5>
						{{-- <input type="hidden" name="sow_registryid" value="{{ $sow->registryid }}"> --}}
						@if(!is_null($family->getGroupingProperties()->where("property_id", 25)->first()))
							<div class="col s4">
	              <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate">
	              <label for="offspring_earnotch">Offspring Earnotch</label>
							</div>
							<div class="col s4">
								<select id="select_sex" name="sex" class="browser-default">
									<option disabled selected>Choose sex</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
							<div class="col s4">
								<input id="birth_weight" type="text" name="birth_weight">
								<label for="birth_weight">Birth Weight, kg</label>
							</div>
						@else
							<div class="col s4">
	              <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate">
	              <label for="offspring_earnotch">Offspring Earnotch</label>
							</div>
							<div class="col s4">
								<select id="select_sex" name="sex" class="browser-default">
									<option disabled selected>Choose sex</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
							<div class="col s4">
								<input id="birth_weight" type="text" name="birth_weight">
								<label for="birth_weight">Birth Weight, kg</label>
							</div>
						@endif
					</div>
				</div>
				<div class="row center">
					<button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully added!', 4000)">Add
            <i class="material-icons right">add</i>
          </button>
				</div>
				{!! Form::close() !!}
				<div class="row">
					<div class="col s12">
						<table class="centered striped">
							<thead>
								<tr class="green lighten-1">
									<th>Offspring ID</th>
									<th>Sex</th>
									<th>Birth weight, kg</th>
									<th>Weaning weight, kg</th>
								</tr>
							</thead>
							<tbody>
								@forelse($offsprings as $offspring)
									<tr>
										<td>{{ $offspring->getChild()->registryid }}</td>
										<td>{{ $offspring->getAnimalProperties()->where("property_id", 27)->first()->value }}</td>
										<td>{{ $offspring->getAnimalProperties()->where("property_id", 53)->first()->value }}</td>
										{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
										@if(is_null($family->getGroupingProperties()->where("property_id", 61)->first()))
											@if(is_null($offspring->getAnimalProperties()->where("property_id", 54)->first()))
												<td>
													<div class="col s6">
														<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->registryid }}">
														<input type="hidden" name="family_id" value="{{ $family->id }}">
														{{-- <input type="hidden" name="date_weaned" value="{{ $family->getGroupingProperties()->where("property_id", 61)->first()->value }}"> --}}
														<input id="weaning_weight" type="text" name="weaning_weight">
													</div>
													<div class="col s6">
														<button class="btn-floating waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Weaning weight added!', 4000)">
									            <i class="material-icons right">add</i>
									          </button>
													</div>
												</td>
											@else
												<td>{{ $offspring->getAnimalProperties()->where("property_id", 54)->first()->value }}</td>
											@endif
										@else
											@if(is_null($offspring->getAnimalProperties()->where("property_id", 54)->first()))
												<td>
													<div class="col s6">
														<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->registryid }}">
														<input type="hidden" name="family_id" value="{{ $family->id }}">
														{{-- <input type="hidden" name="date_weaned" value="{{ $family->getGroupingProperties()->where("property_id", 61)->first()->value }}"> --}}
														<input id="weaning_weight" type="text" name="weaning_weight">
													</div>
													<div class="col s6">
														<button class="btn-floating waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Weaning weight added!', 4000)">
									            <i class="material-icons right">add</i>
									          </button>
													</div>
												</td>
											@else
												<td>{{ $offspring->getAnimalProperties()->where("property_id", 54)->first()->value }}</td>
											@endif
										@endif
										{!! Form::close() !!}
									</tr>
								@empty
									<tr>
										<td colspan="4">No offspring data found</td>
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

@section('scripts')
		<script>
		$(document).ready(function(){
		  $("#paritytext").change(function (event) {
		    event.preventDefault();
		    var familyidvalue = $('input[name=grouping_id]').val();
		    var parityvalue = $('input[name=parity]').val();
		    $.ajax({
		    	headers: {
          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
		      url: '../fetch_parity/'+familyidvalue+'/'+parityvalue,
		      type: 'POST',
		      cache: false,
		      data: {familyidvalue, parityvalue},
		      success: function(data)
		      {
		        Materialize.toast('Parity successfully added!', 4000);
		      }
		    });
		  });
		});
	</script>
@endsection
