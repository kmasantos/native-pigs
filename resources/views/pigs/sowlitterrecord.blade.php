@extends('layouts.swinedefault')

@section('title')
	Sow and Litter Record
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.breeding_record')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Sow and Litter Record</h4>
		{{-- <h4><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Sow and Litter Record</h4> --}}
		<div class="divider"></div>
		{!! Form::open(['route' => 'farm.pig.get_sowlitter_record', 'method' => 'post']) !!}
    <div class="row">
    	<input type="hidden" name="grouping_id" value="{{ $family->id }}">
			<div class="col s12">
				<div class="row center">
					<div class="col s12">
						<div class="col s6 center">
							<h5>Sow used: <strong>{{ $family->getMother()->registryid }}</strong></h5>
						</div>
						<div class="col s6 center">
							<h5>Boar used: <strong>{{ $family->getFather()->registryid }}</strong></h5>
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
								<div class="col s6">
									Date Bred
								</div>
								<div class="col s6">
									{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->format('j F, Y') }}
								</div>
							</div>
							<div class="row">
								@if($gestationperiod == "")

								@elseif($gestationperiod != "")
									<div class="col s10">
										<p class="center"><strong>Gestation Period:</strong> {{ $gestationperiod }} days</p>
									</div>
								@endif
							</div>
							<div class="row">
								@if(is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
									<div class="col s6">
										<p>Date Farrowed</p>
									</div>
									<div class="col s6">
										<input id="date_farrowed" type="date" name="date_farrowed">
									</div>
								@else
									<div class="col s6">
										Date Farrowed
									</div>
									<div class="col s6">
										<input id="datefarrowed" type="date" name="date_farrowed" value="{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 3)->first()->value)->format('Y-m-d') }}">
									</div>
								@endif
							</div>
							<div class="row">
								@if($lactationperiod == "")

								@elseif($lactationperiod != "")
									<div class="col s10">
										<p class="center"><strong>Lactation Period:</strong> {{ $lactationperiod }} days </p>
									</div>
								@endif
							</div>
							<div class="row">
								@if(!is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
									@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
										<div class="col s6">
											<p>Date Weaned</p>
										</div>
										<div class="col s6">
											
										</div>
									@else
										<div class="col s6">
											Date Weaned
										</div>
										<div class="col s6">
											@if($family->getGroupingProperties()->where("property_id", 6)->first()->value != "Not specified")
												<input id="dateweaned" type="date" name="date_weaned" value="{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 6)->first()->value)->format('Y-m-d') }}">
											@else
												No offsprings to wean
											@endif
										</div>
									@endif
								@else
									<div class="col s6">
										<p>Date Weaned</p>
									</div>
									<div class="col s6">
										
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
									@if(is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
										@if(is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
											<input id="paritytext" type="text" name="parity"> 
										@else
											<input id="paritytext" type="text" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
										@endif
									@else
										@if(is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
											<input id="paritytext" type="text" name="parity"> 
										@else
											<input id="paritytext" type="text" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Total Littersize Born
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 49)->first()))
											{{ $properties->where("property_id", 49)->first()->value }}
										@else
											{{ $properties->where("property_id", 45)->first()->value + $properties->where("property_id", 46)->first()->value + count($offsprings) }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Total Littersize Born Alive
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 50)->first()))
											{{ $properties->where("property_id", 50)->first()->value }}
										@else
											{{ count($offsprings) }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Number of males
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 51)->first()))
											{{ $properties->where("property_id", 51)->first()->value }}
										@else
											{{ $countMales }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Number of females
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 52)->first()))
											{{ $properties->where("property_id", 52)->first()->value }}
										@else
											{{ $countFemales }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Sex ratio (Male to Female)
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 53)->first()))
											{{ $properties->where("property_id", 53)->first()->value }}
										@else
											{{ $countMales }}:{{ $countFemales }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Average birth weight
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 56)->first()))
											{{ round($properties->where("property_id", 56)->first()->value, 3) }}
										@else
											{{ round($aveBirthWeight, 3) }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Number weaned
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 57)->first()))
											{{ $properties->where("property_id", 57)->first()->value }}
										@else
											{{ $weaned }}
										@endif
									@endif
								</div>
							</div>
							<div class="row">
								<div class="col s8">
									Average weaning weight
								</div>
								<div class="col s4">
									@if($family->members == 1)
										@if(!is_null($properties->where("property_id", 58)->first()))
											{{ round($properties->where("property_id", 58)->first()->value, 3) }}
										@else
											{{ round($aveWeaningWeight, 3) }}
										@endif
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row center">
					<div class="col s6">
						@if(is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
							@if(is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn">
								</div>
							@else
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
								</div>
							@endif
						@else
							@if(is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn">
								</div>
							@else
								Number Stillborn:
								<div class="input-field inline">
									<input id="number_stillborn" type="text" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
								</div>
							@endif
						@endif
					</div>
					<div class="col s6">
						@if(is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
							@if(is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified">
								</div>
							@else
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
								</div>
							@endif
						@else
							@if(is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified">
								</div>
							@else
								Number Mummified:
								<div class="input-field inline">
									<input id="number_mummified" type="text" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
								</div>
							@endif
						@endif
					</div>
					<div class="col s12 center">
						@if(is_null($family->getGroupingProperties()->where("property_id", 47)->first()))
							<div class="input-field col s8 offset-s2">
			          <textarea id="abnomalities" name="abnomalities" class="materialize-textarea" placeholder="Enter values separated by commas"></textarea>
			          <label for="abnomalities">Abnormalities</label>
			        </div>
			      @else
			      	<div class="input-field col s8 offset-s2">
			          <textarea id="abnomalities" name="abnomalities" class="materialize-textarea" value="{{ $family->getGroupingProperties()->where("property_id", 47)->first()->value }}"></textarea>
			          <label for="abnomalities">Abnormalities</label>
			        </div>
			      @endif
					</div>
					<div class="col s12 center">
						@if(is_null($family->getGroupingProperties()->where("property_id", 54)->first()))
							<div class="switch">
								<label>
									Group Weighing
									<input id="weighing_options" checked type="checkbox">
									<span class="lever"></span>
									Individual Weighing
								</label>
							</div>
						@else
							@if($family->getGroupingProperties()->where("property_id", 54)->first()->value == 0)
								<div class="switch">
									<label>
										Group Weighing
										<input id="weighing_options" type="checkbox">
										<span class="lever"></span>
										Individual Weighing
									</label>
								</div>
							@elseif($family->getGroupingProperties()->where("property_id", 54)->first()->value == 1)
								<div class="switch">
									<label>
										Group Weighing
										<input id="weighing_options" checked type="checkbox">
										<span class="lever"></span>
										Individual Weighing
									</label>
								</div>
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			@if(is_null($family->getGroupingProperties()->where("property_id", 54)->first()))
				{{-- INDIVIDUAL WEIGHING IS DISPLAYED, DEFAULT --}}
				<div id="individual_weighing1" class="col s12" style="display: block;">
					<h5  class="green darken-3 white-text center">Individual Weighing</h5>
					<h5 class="green lighten-1 center">Add offspring</h5>
					<div class="col s4">
	          <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate" data-length="6">
	          <label for="offspring_earnotch">Offspring Earnotch</label>
	          <input type="hidden" name="option" value="1">
					</div>
					<div class="col s4">
						<select id="select_sex" name="sex" class="browser-default">
							<option disabled selected>Choose sex</option>
							<option value="M">Male</option>
							<option value="F">Female</option>
						</select>
					</div>
					<div class="col s4">
						<input id="birth_weight" type="number" name="birth_weight" min="0.001" max="1.599" step="0.001">
						<label for="birth_weight">Birth Weight, kg</label>
					</div>
				</div>
				<div id="individual_weighing2" class="row center" style="display: block;">
					<button class="btn waves-effect waves-light green darken-3" type="submit">Add
	          <i class="material-icons right">add</i>
	        </button>
	        {!! Form::close() !!}
				</div>
				<div id="individual_weighing3" class="row" style="display: block;">
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
										{{-- OFFSPRING ID --}}
										{!! Form::open(['route' => 'farm.pig.edit_id', 'method' => 'post']) !!}
										<td>{{ $offspring->getChild()->registryid }}  <a href="#edit_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
											{{-- MODAL STRUCTURE --}}
											<div id="edit_id{{$offspring->getChild()->id}}" class="modal">
												<div class="modal-content">
													<h5 class="center">Edit Earnotch:<br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
													<input type="hidden" name="old_earnotch" value="{{ $offspring->getChild()->id }}">
													<div class="row center">
														<div class="input-field col s8 offset-s2">
															<input id="new_earnotch" type="text" name="new_earnotch" class="validate" data-length="6">
															<label for="new_earnotch">New Earnotch</label>
														</div>
													</div>
												</div>
												<div class="row center">
													<button class="btn waves-effect waves-light green darken-3" type="submit">
								            Submit <i class="material-icons right">send</i>
								          </button>
												</div>
											</div>
										{!! Form::close() !!}
										{!! Form::open(['route' => 'farm.pig.edit_sex', 'method' => 'post']) !!}
										{{-- SEX --}}
										<td>{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}  <a href="#edit_sex{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
											{{-- MODAL STRUCTURE --}}
											<div id="edit_sex{{$offspring->getChild()->id}}" class="modal">
												<div class="modal-content">
													<h5 class="center">Edit Sex of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
													<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
													<div class="row center">
														<div class="col s8 offset-s2">
															<select id="new_sex" name="new_sex" class="browser-default">
																<option disabled selected>Choose sex</option>
																<option value="M">Male</option>
																<option value="F">Female</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row center">
													<button class="btn waves-effect waves-light green darken-3" type="submit">
								            Submit <i class="material-icons right">send</i>
								          </button>
												</div>
											</div>
										{!! Form::close() !!}
										{!! Form::open(['route' => 'farm.pig.edit_birth_weight', 'method' => 'post']) !!}
										{{-- BIRTH WEIGHT --}}
										<td>{{ $offspring->getAnimalProperties()->where("property_id", 5)->first()->value }} <a href="#edit_birth_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
											{{-- MODAL STRUCTURE --}}
											<div id="edit_birth_weight{{$offspring->getChild()->id}}" class="modal">
												<div class="modal-content">
													<h5 class="center">Edit Birth Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
													<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
													<div class="row center">
														<div class="col s8 offset-s2">
															<input id="new_birth_weight" type="number" name="new_birth_weight" min="0.001" max="1.599" step="0.001">
														</div>
													</div>
												</div>
												<div class="row center">
													<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
								          			</button>
												</div>
											</div>
										{!! Form::close() !!}
										{{-- WEANING WEIGHT --}}
										@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
										{{-- no weaning data --}}
											@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
												{{-- inactive grower --}}
												<td>
													<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
												</td>
											@else
												@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
													{{-- no weaning weight yet --}}
													<td>
														{{-- 21d+ --}}
														{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
														@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
															<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
										          			</a>
										          		{{-- <21d --}}
										        		@else
										        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
										        		@endif
										        		{{-- MODAL STRUCTURE --}}
														<div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
															<div class="modal-content">
																<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																<input type="hidden" name="family_id" value="{{ $family->id }}">
																<div class="row center">
																	<div class="col s8 offset-s2 center">
																		Date Weaned:
																		@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																			<div class="input-field inline">
																				<input id="date_weaned" type="date" name="date_weaned">
																			</div>
																		@else
																			<div class="input-field inline">
																				<input id="date_weaned" type="date" name="date_weaned" value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																			</div>
																		@endif
																	</div>
																	<div class="col s8 offset-s2 center">
																		Weaning Weight, kg:
																		<div class="input-field inline">
																			<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row center">
																<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
											          			</button>
															</div>
														</div>
										        		{!! Form::close() !!}
													</td>
												@else
													{{-- with weaning weight --}}
													{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
													<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
													{{-- MODAL STRUCTURE --}}
													<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
														<div class="modal-content">
															<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
															<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
															<div class="row center">
																<div class="col s8 offset-s2">
																	<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																</div>
															</div>
														</div>
														<div class="row center">
															<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
										          			</button>
														</div>
													</div>
													{!! Form::close() !!}
												@endif
											@endif
										@else
										{{-- with weaning data --}}
											@if($family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
											{{-- all offsprings dead/sold before weaning --}}
												<td>
													<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
												</td>
											@else
											{{-- if at least 1 offspring is alive --}}
												@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
													{{-- inactive grower --}}
													@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
														<td>
															<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
														</td>
													@else
													{{-- active with weaning weight--}}
														{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
														{{-- MODAL STRUCTURE --}}
														<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
															<div class="modal-content">
																<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																<div class="row center">
																	<div class="col s8 offset-s2">
																		<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																	</div>
																</div>
															</div>
															<div class="row center">
																<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
											          			</button>
															</div>
														</div>
														{!! Form::close() !!}
													@endif
												@else
													{{-- no weaning weight yet --}}
													@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
														<td>
															{{-- 21d+ --}}
															{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
															@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
											          			</a>
											          		{{-- <21d --}}
											        		@else
											        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
											        		@endif
											        		{{-- MODAL STRUCTURE --}}
															<div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																	<input type="hidden" name="family_id" value="{{ $family->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2 center">
																			Date Weaned:
																			@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  >
																				</div>
																			@else
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																				</div>
																			@endif
																		</div>
																		<div class="col s8 offset-s2 center">
																			Weaning Weight, kg:
																			<div class="input-field inline">
																				<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div>
											        		{!! Form::close() !!}
														</td>
													@else
													{{-- with weaning weight --}}
														{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
														{{-- MODAL STRUCTURE --}}
														<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
															<div class="modal-content">
																<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																<div class="row center">
																	<div class="col s8 offset-s2">
																		<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																	</div>
																</div>
															</div>
															<div class="row center">
																<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
											          			</button>
															</div>
														</div>
														{!! Form::close() !!}
													@endif
												@endif
											@endif
										@endif
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
				{{-- GROUP WEIGHING IS HIDDEN --}}
				{!! Form::open(['route' => 'farm.pig.add_sowlitter_record_group', 'method' => 'post']) !!}
				<div id="group_weighing" class="row center" style="display: none;">
					<h5 class="green darken-3 white-text">Group Weighing</h5>
					<input type="hidden" name="grouping_id" value="{{ $family->id }}">
					@if(!is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
						<input id="hidden_date" type="hidden" name="date_farrowed" value="{{ $family->getGroupingProperties()->where("property_id", 3)->first()->value }}">
					@endif
					@if(!is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
						<input id="parity" type="hidden" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
					@endif
					@if(!is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
						<input id="number_stillborn" type="hidden" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
					@endif
					@if(!is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
						<input id="number_mummified" type="hidden" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
					@endif
					@if(!is_null($family->getGroupingProperties()->where("property_id", 47)->first()))
						<input type="hidden" name="abnomalities" value="{{ $family->getGroupingProperties()->where("property_id", 47)->first()->value }}">
					@endif
					<div class="row">
						<div class="col s4 offset-s2">
							Litter Birth Weight, kg
							@if(!is_null($family->getGroupingProperties()->where("property_id", 55)->first()))
								<div class="input-field inline">
									<input id="litter_birth_weight" type="number" name="litter_birth_weight" value="{{ $family->getGroupingProperties()->where("property_id", 55)->first()->value }}" min="0.000" step="0.001">
								</div>
							@else
								<div class="input-field inline">
									<input id="litter_birth_weight" type="number" name="litter_birth_weight" min="0.000" step="0.001">
								</div>
							@endif
						</div>
						<div class="col s4">
							Litter-size Born Alive
							@if(!is_null($family->getGroupingProperties()->where("property_id", 50)->first()))
								<div class="input-field inline">
									<input id="lsba" type="text" name="lsba" value="{{ $family->getGroupingProperties()->where("property_id", 50)->first()->value }}">
								</div>
							@else
								<div class="input-field inline">
									<input id="lsba" type="text" name="lsba">
								</div>
							@endif
						</div>
					</div>
					<h5 class="green lighten-1">Add offspring</h5>
					<div class="row">
						<div class="col s4 push-s2">
	            <input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate" data-length="6">
	            <label for="offspring_earnotch">Offspring Earnotch</label>
	            <input type="hidden" name="option" value="0">
						</div>
						<div class="col s4 push-s2">
							<select id="select_sex" name="sex" class="browser-default">
								<option disabled selected>Choose sex</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>
						</div>
					</div>
					<div class="row center">
						<button class="btn waves-effect waves-light green darken-3" type="submit">Add
	            <i class="material-icons right">add</i>
	          </button>
	          {!! Form::close() !!}
					</div>
					<div class="row center">
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
										{!! Form::open(['route' => 'farm.pig.edit_temporary_registryid', 'method' => 'post']) !!}
										<tr>
											@if($offspring->getChild()->status == "temporary")
												<td>
													{{ $offspring->getChild()->registryid }} <a href="#edit_temp_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a>
												</td>
											@else
												<td>
													{{ $offspring->getChild()->registryid }} {{-- <a href="#edit_temp_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a> --}}
												</td>
											@endif
											{{-- MODAL STRUCTURE --}}
											{{-- <div id="edit_temp_id{{$offspring->getChild()->id}}" class="modal">
												<div class="modal-content">
													<h5 class="center">Edit Temporary Earnotch:<br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
													<input type="hidden" name="old_earnotch" value="{{ $offspring->getChild()->id }}">
													<div class="row center">
														<div class="input-field col s8 offset-s2">
															<input id="new_earnotch" type="text" name="new_earnotch" class="validate" data-length="6">
															<label for="new_earnotch">New Earnotch</label>
														</div>
													</div>
												</div>
												<div class="row center">
													<button class="btn waves-effect waves-light green darken-3" type="submit">
								            Submit <i class="material-icons right">send</i>
								          </button>
												</div>
											</div> --}}
											{!! Form::close() !!}
											{!! Form::open(['route' => 'farm.pig.edit_sex', 'method' => 'post']) !!}
											<td>{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}  <a href="#edit_sex{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
												{{-- MODAL STRUCTURE --}}
												{{-- <div id="edit_sex{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Sex of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="col s8 offset-s2">
																<select id="new_sex" name="new_sex" class="browser-default">
																	<option disabled selected>Choose sex</option>
																	<option value="M">Male</option>
																	<option value="F">Female</option>
																</select>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div> --}}
											{!! Form::close() !!}
											<td>{{ round($offspring->getAnimalProperties()->where("property_id", 5)->first()->value, 4) }}</td>
											{{-- WEANING WEIGHT --}}
											@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
											{{-- no weaning data --}}
												@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
													{{-- inactive grower --}}
													<td>
														<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
													</td>
												@else
													@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
														{{-- no weaning weight yet --}}
														<td>
															{{-- 21d+ --}}
															{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
															@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
											          			</a>
											          		{{-- <21d --}}
											        		@else
											        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
											        		@endif
											        		{{-- MODAL STRUCTURE --}}
															{{-- <div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																	<input type="hidden" name="family_id" value="{{ $family->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2 center">
																			Date Weaned:
																			@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  >
																				</div>
																			@else
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																				</div>
																			@endif
																		</div>
																		<div class="col s8 offset-s2 center">
																			Weaning Weight, kg:
																			<div class="input-field inline">
																				<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div> --}}
											        		{!! Form::close() !!}
														</td>
													@else
														{{-- with weaning weight --}}
														{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
														{{-- MODAL STRUCTURE --}}
{{-- 														<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
															<div class="modal-content">
																<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																<div class="row center">
																	<div class="col s8 offset-s2">
																		<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																	</div>
																</div>
															</div>
															<div class="row center">
																<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
											          			</button>
															</div>
														</div> --}}
														{!! Form::close() !!}
													@endif
												@endif
											@else
											{{-- with weaning data --}}
												@if($family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
												{{-- all offsprings dead/sold before weaning --}}
													<td>
														<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
													</td>
												@else
												{{-- if at least 1 offspring is alive --}}
													@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
														{{-- inactive grower --}}
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															<td>
																<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
															</td>
														@else
														{{-- active with weaning weight--}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
{{-- 															<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div> --}}
															{!! Form::close() !!}
														@endif
													@else
														{{-- no weaning weight yet --}}
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															<td>
																{{-- 21d+ --}}
																{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																	<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
												          			</a>
												          		{{-- <21d --}}
												        		@else
												        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
												        		@endif
												        		{{-- MODAL STRUCTURE --}}
																{{-- <div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																		<input type="hidden" name="family_id" value="{{ $family->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2 center">
																				Date Weaned:
																				@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  >
																					</div>
																				@else
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																					</div>
																				@endif
																			</div>
																			<div class="col s8 offset-s2 center">
																				Weaning Weight, kg:
																				<div class="input-field inline">
																					<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div> --}}
												        		{!! Form::close() !!}
															</td>
														@else
														{{-- with weaning weight --}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div> --}}
															{!! Form::close() !!}
														@endif
													@endif
												@endif
											@endif
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
			@else
				@if($family->getGroupingProperties()->where("property_id", 54)->first()->value == 1)
					{{-- INDIVIDUAL WEIGHING IS DISPLAYED --}}
					{!! Form::open(['route' => 'farm.pig.add_sowlitter_record_individual', 'method' => 'post']) !!}
					<div id="individual_weighing1" class="col s12" style="display: block;">
						<h5  class="green darken-3 white-text center">Individual Weighing</h5>
						<h5 class="green lighten-1 center">Add offspring</h5>
						<input type="hidden" name="grouping_id" value="{{ $family->id }}">
						@if(!is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
							<input id="hidden_date" type="hidden" name="date_farrowed" value="{{ $family->getGroupingProperties()->where("property_id", 3)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
							<input id="parity" type="hidden" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
							<input id="number_stillborn" type="hidden" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
							<input id="number_mummified" type="hidden" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 47)->first()))
							<input type="hidden" name="abnomalities" value="{{ $family->getGroupingProperties()->where("property_id", 47)->first()->value }}">
						@endif
						<div class="col s4">
							<input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate" data-length="6">
							<label for="offspring_earnotch">Offspring Earnotch</label>
							<input type="hidden" name="option" value="1">
						</div>
						<div class="col s4">
							<select id="select_sex" name="sex" class="browser-default">
								<option disabled selected>Choose sex</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>
						</div>
						<div class="col s4">
							<input id="birth_weight" type="number" name="birth_weight" min="0.001" max="1.599" step="0.001">
							<label for="birth_weight">Birth Weight, kg</label>
						</div>
					</div>
					<div id="individual_weighing2" class="row center" style="display: block;">
						<button class="btn waves-effect waves-light green darken-3" type="submit">Add
	            <i class="material-icons right">add</i>
	          </button>
					</div>
					{!! Form::close() !!}
					<div id="individual_weighing3" class="row" style="display: block;">
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
											{!! Form::open(['route' => 'farm.pig.edit_id', 'method' => 'post']) !!}
											<td>{{ $offspring->getChild()->registryid }}  <a href="#edit_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
												{{-- MODAL STRUCTURE --}}
												<div id="edit_id{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Earnotch:<br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="old_earnotch" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="input-field col s8 offset-s2">
																<input id="new_earnotch" type="text" name="new_earnotch" class="validate" data-length="6">
																<label for="new_earnotch">New Earnotch</label>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div>
											{!! Form::close() !!}
											{!! Form::open(['route' => 'farm.pig.edit_sex', 'method' => 'post']) !!}
											<td>{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}  <a href="#edit_sex{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
												{{-- MODAL STRUCTURE --}}
												<div id="edit_sex{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Sex of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="col s8 offset-s2">
																<select id="new_sex" name="new_sex" class="browser-default">
																	<option disabled selected>Choose sex</option>
																	<option value="M">Male</option>
																	<option value="F">Female</option>
																</select>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div>
											{!! Form::close() !!}
											{!! Form::open(['route' => 'farm.pig.edit_birth_weight', 'method' => 'post']) !!}
											{{-- BIRTH WEIGHT --}}
											<td>{{ $offspring->getAnimalProperties()->where("property_id", 5)->first()->value }} <a href="#edit_birth_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
												{{-- MODAL STRUCTURE --}}
												<div id="edit_birth_weight{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Birth Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="col s8 offset-s2">
																<input id="new_birth_weight" type="number" name="new_birth_weight" min="0.001" max="1.599" step="0.001">
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div>
											{!! Form::close() !!}
											@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
											{{-- no weaning data --}}
												@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
													{{-- inactive grower --}}
													<td>
														<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
													</td>
												@else
													@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
														{{-- no weaning weight yet --}}
														<td>
															{{-- 21d+ --}}
															{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
															@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
											          			</a>
											          		{{-- <21d --}}
											        		@else
											        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
											        		@endif
											        		{{-- MODAL STRUCTURE --}}
															<div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																	<input type="hidden" name="family_id" value="{{ $family->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2 center">
																			Date Weaned:
																			@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  >
																				</div>
																			@else
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																				</div>
																			@endif
																		</div>
																		<div class="col s8 offset-s2 center">
																			Weaning Weight, kg:
																			<div class="input-field inline">
																				<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div>
											        		{!! Form::close() !!}
														</td>
													@else
														{{-- with weaning weight --}}
														{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
														{{-- MODAL STRUCTURE --}}
														<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
															<div class="modal-content">
																<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																<div class="row center">
																	<div class="col s8 offset-s2">
																		<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																	</div>
																</div>
															</div>
															<div class="row center">
																<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
											          			</button>
															</div>
														</div>
														{!! Form::close() !!}
													@endif
												@endif
											@else
											{{-- with weaning data --}}
												@if($family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
												{{-- all offsprings dead/sold before weaning --}}
													<td>
														<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
													</td>
												@else
												{{-- if at least 1 offspring is alive --}}
													@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
														{{-- inactive grower --}}
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															<td>
																<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
															</td>
														@else
														{{-- active with weaning weight--}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div>
															{!! Form::close() !!}
														@endif
													@else
														{{-- no weaning weight yet --}}
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															<td>
																{{-- 21d+ --}}
																{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																	<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
												          			</a>
												          		{{-- <21d --}}
												        		@else
												        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
												        		@endif
												        		{{-- MODAL STRUCTURE --}}
																<div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																		<input type="hidden" name="family_id" value="{{ $family->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2 center">
																				Date Weaned:
																				@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  >
																					</div>
																				@else
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																					</div>
																				@endif
																			</div>
																			<div class="col s8 offset-s2 center">
																				Weaning Weight, kg:
																				<div class="input-field inline">
																					<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div>
												        		{!! Form::close() !!}
															</td>
														@else
														{{-- with weaning weight --}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div>
															{!! Form::close() !!}
														@endif
													@endif
												@endif
											@endif
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
					{{-- GROUP WEIGHING IS HIDDEN --}}
					{!! Form::open(['route' => 'farm.pig.add_sowlitter_record_group', 'method' => 'post']) !!}
					<div id="group_weighing" class="row center" style="display: none;">
						<h5 class="green darken-3 white-text">Group Weighing</h5>
						<input type="hidden" name="grouping_id" value="{{ $family->id }}">
						@if(!is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
							<input id="hidden_date" type="hidden" name="date_farrowed" value="{{ $family->getGroupingProperties()->where("property_id", 3)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
							<input id="parity" type="hidden" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
							<input id="number_stillborn" type="hidden" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
							<input id="number_mummified" type="hidden" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 47)->first()))
							<input type="hidden" name="abnomalities" value="{{ $family->getGroupingProperties()->where("property_id", 47)->first()->value }}">
						@endif
						<div class="row">
							<div class="col s4 offset-s2">
								Litter Birth Weight, kg
								@if(!is_null($family->getGroupingProperties()->where("property_id", 55)->first()))
									<div class="input-field inline">
										<input id="litter_birth_weight" type="number" name="litter_birth_weight" value="{{ $family->getGroupingProperties()->where("property_id", 55)->first()->value }}" min="0.000" step="0.001">
									</div>
								@else
									<div class="input-field inline">
										<input id="litter_birth_weight" type="number" name="litter_birth_weight" min="0.000" step="0.001">
									</div>
								@endif
							</div>
							<div class="col s4">
								Litter-size Born Alive
								@if(!is_null($family->getGroupingProperties()->where("property_id", 50)->first()))
									<div class="input-field inline">
										<input id="lsba" type="text" name="lsba" value="{{ $family->getGroupingProperties()->where("property_id", 50)->first()->value }}">
									</div>
								@else
									<div class="input-field inline">
										<input id="lsba" type="text" name="lsba">
									</div>
								@endif
							</div>
						</div>
						<h5 class="green lighten-1">Add offspring</h5>
						<div class="row">
							<div class="col s4 push-s2">
								<input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate" data-length="6">
								<label for="offspring_earnotch">Offspring Earnotch</label>
								<input type="hidden" name="option" value="0">
							</div>
							<div class="col s4 push-s2">
								<select id="select_sex" name="sex" class="browser-default">
									<option disabled selected>Choose sex</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
						</div>
						<div class="row center">
							<button class="btn waves-effect waves-light green darken-3" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
		          {!! Form::close() !!}
						</div>
						<div class="row center">
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
											{!! Form::open(['route' => 'farm.pig.edit_temporary_registryid', 'method' => 'post']) !!}
											<tr>
												@if($offspring->getChild()->status == "temporary")
												<td>
													{{ $offspring->getChild()->registryid }} <a href="#edit_temp_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a>
												</td>
											@else
												<td>
													{{ $offspring->getChild()->registryid }} {{-- <a href="#edit_temp_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a> --}}
												</td>
											@endif
												{{-- MODAL STRUCTURE --}}
												{{-- <div id="edit_temp_id{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Temporary Earnotch:<br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="old_earnotch" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="input-field col s8 offset-s2">
																<input id="new_earnotch" type="text" name="new_earnotch" class="validate" data-length="6">
																<label for="new_earnotch">New Earnotch</label>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div> --}}
												{!! Form::close() !!}
												{!! Form::open(['route' => 'farm.pig.edit_sex', 'method' => 'post']) !!}
												<td>{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}  <a href="#edit_sex{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
													{{-- MODAL STRUCTURE --}}
													{{-- <div id="edit_sex{{$offspring->getChild()->id}}" class="modal">
														<div class="modal-content">
															<h5 class="center">Edit Sex of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
															<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
															<div class="row center">
																<div class="col s8 offset-s2">
																	<select id="new_sex" name="new_sex" class="browser-default">
																		<option disabled selected>Choose sex</option>
																		<option value="M">Male</option>
																		<option value="F">Female</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row center">
															<button class="btn waves-effect waves-light green darken-3" type="submit">
										            Submit <i class="material-icons right">send</i>
										          </button>
														</div>
													</div> --}}
												{!! Form::close() !!}
												<td>{{ round($offspring->getAnimalProperties()->where("property_id", 5)->first()->value, 4) }}</td>
												@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
												{{-- no weaning data --}}
													@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
														{{-- inactive grower --}}
														<td>
															<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
														</td>
													@else
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															{{-- no weaning weight yet --}}
															<td>
																{{-- 21d+ --}}
																{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																	<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
												          			</a>
												          		{{-- <21d --}}
												        		@else
												        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
												        		@endif
												        		{{-- MODAL STRUCTURE --}}
																{{-- <div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																		<input type="hidden" name="family_id" value="{{ $family->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2 center">
																				Date Weaned:
																				@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  >
																					</div>
																				@else
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																					</div>
																				@endif
																			</div>
																			<div class="col s8 offset-s2 center">
																				Weaning Weight, kg:
																				<div class="input-field inline">
																					<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div> --}}
												        		{!! Form::close() !!}
															</td>
														@else
															{{-- with weaning weight --}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div> --}}
															{!! Form::close() !!}
														@endif
													@endif
												@else
												{{-- with weaning data --}}
													@if($family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
													{{-- all offsprings dead/sold before weaning --}}
														<td>
															<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
														</td>
													@else
													{{-- if at least 1 offspring is alive --}}
														@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
															{{-- inactive grower --}}
															@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
																<td>
																	<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
																</td>
															@else
															{{-- active with weaning weight--}}
																{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
																<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
																{{-- MODAL STRUCTURE --}}
																{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2">
																				<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div> --}}
																{!! Form::close() !!}
															@endif
														@else
															{{-- no weaning weight yet --}}
															@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
																<td>
																	{{-- 21d+ --}}
																	{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																	@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																		<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
													          			</a>
													          		{{-- <21d --}}
													        		@else
													        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
													        		@endif
													        		{{-- MODAL STRUCTURE --}}
																	{{-- <div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																		<div class="modal-content">
																			<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																			<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																			<input type="hidden" name="family_id" value="{{ $family->id }}">
																			<div class="row center">
																				<div class="col s8 offset-s2 center">
																					Date Weaned:
																					@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																						<div class="input-field inline">
																							<input id="date_weaned" type="date" name="date_weaned"  >
																						</div>
																					@else
																						<div class="input-field inline">
																							<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																						</div>
																					@endif
																				</div>
																				<div class="col s8 offset-s2 center">
																					Weaning Weight, kg:
																					<div class="input-field inline">
																						<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="row center">
																			<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
														          			</button>
																		</div>
																	</div> --}}
													        		{!! Form::close() !!}
																</td>
															@else
															{{-- with weaning weight --}}
																{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
																<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
																{{-- MODAL STRUCTURE --}}
																{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2">
																				<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div> --}}
																{!! Form::close() !!}
															@endif
														@endif
													@endif
												@endif
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
				@elseif($family->getGroupingProperties()->where("property_id", 54)->first()->value == 0)
					{{-- INDIVIDUAL WEIGHING IS HIDDEN --}}
					{!! Form::open(['route' => 'farm.pig.add_sowlitter_record_individual', 'method' => 'post']) !!}
					<div id="individual_weighing1" class="col s12" style="display: none;">
						<h5  class="green darken-3 white-text center">Individual Weighing</h5>
						<h5 class="green lighten-1 center">Add offspring</h5>
						<input type="hidden" name="grouping_id" value="{{ $family->id }}">
						@if(!is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
							<input id="hidden_date" type="hidden" name="date_farrowed" value="{{ $family->getGroupingProperties()->where("property_id", 3)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
							<input id="parity" type="hidden" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
							<input id="number_stillborn" type="hidden" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
							<input id="number_mummified" type="hidden" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 47)->first()))
							<input type="hidden" name="abnomalities" value="{{ $family->getGroupingProperties()->where("property_id", 47)->first()->value }}">
						@endif
						<div class="col s4">
							<input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate" data-length="6">
							<label for="offspring_earnotch">Offspring Earnotch</label>
							<input type="hidden" name="option" value="1">
						</div>
						<div class="col s4">
							<select id="select_sex" name="sex" class="browser-default">
								<option disabled selected>Choose sex</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>
						</div>
						<div class="col s4">
							<input id="birth_weight" type="number" name="birth_weight" min="0.001" max="1.599" step="0.001">
							<label for="birth_weight">Birth Weight, kg</label>
						</div>
					</div>
					<div id="individual_weighing2" class="row center" style="display: none;">
						<button class="btn waves-effect waves-light green darken-3" type="submit">Add
	            <i class="material-icons right">add</i>
	          </button>
					</div>
					{!! Form::close() !!}
					<div id="individual_weighing3" class="row" style="display: none;">
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
											{!! Form::open(['route' => 'farm.pig.edit_id', 'method' => 'post']) !!}
											<td>{{ $offspring->getChild()->registryid }}  <a href="#edit_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
												{{-- MODAL STRUCTURE --}}
												{{-- <div id="edit_id{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Earnotch:<br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="old_earnotch" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="input-field col s8 offset-s2">
																<input id="new_earnotch" type="text" name="new_earnotch" class="validate" data-length="6">
																<label for="new_earnotch">New Earnotch</label>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div> --}}
											{!! Form::close() !!}
											{!! Form::open(['route' => 'farm.pig.edit_sex', 'method' => 'post']) !!}
											<td>{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}  <a href="#edit_sex{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
												{{-- MODAL STRUCTURE --}}
												{{-- <div id="edit_sex{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Sex of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="col s8 offset-s2">
																<select id="new_sex" name="new_sex" class="browser-default">
																	<option disabled selected>Choose sex</option>
																	<option value="M">Male</option>
																	<option value="F">Female</option>
																</select>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div> --}}
											{!! Form::close() !!}
											<td>{{ $offspring->getAnimalProperties()->where("property_id", 5)->first()->value }}</td>
											@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
											{{-- no weaning data --}}
												@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
													{{-- inactive grower --}}
													<td>
														<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
													</td>
												@else
													@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
														{{-- no weaning weight yet --}}
														<td>
															{{-- 21d+ --}}
															{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
															@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
											          			</a>
											          		{{-- <21d --}}
											        		@else
											        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
											        		@endif
											        		{{-- MODAL STRUCTURE --}}
															{{-- <div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																	<input type="hidden" name="family_id" value="{{ $family->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2 center">
																			Date Weaned:
																			@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  >
																				</div>
																			@else
																				<div class="input-field inline">
																					<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																				</div>
																			@endif
																		</div>
																		<div class="col s8 offset-s2 center">
																			Weaning Weight, kg:
																			<div class="input-field inline">
																				<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div> --}}
											        		{!! Form::close() !!}
														</td>
													@else
														{{-- with weaning weight --}}
														{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
														<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
														{{-- MODAL STRUCTURE --}}
														{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
															<div class="modal-content">
																<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																<div class="row center">
																	<div class="col s8 offset-s2">
																		<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																	</div>
																</div>
															</div>
															<div class="row center">
																<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
											          			</button>
															</div>
														</div> --}}
														{!! Form::close() !!}
													@endif
												@endif
											@else
											{{-- with weaning data --}}
												@if($family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
												{{-- all offsprings dead/sold before weaning --}}
													<td>
														<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
													</td>
												@else
												{{-- if at least 1 offspring is alive --}}
													@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
														{{-- inactive grower --}}
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															<td>
																<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
															</td>
														@else
														{{-- active with weaning weight--}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div> --}}
															</div>
															{!! Form::close() !!}
														@endif
													@else
														{{-- no weaning weight yet --}}
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															<td>
																{{-- 21d+ --}}
																{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																	<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
												          			</a>
												          		{{-- <21d --}}
												        		@else
												        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
												        		@endif
												        		{{-- MODAL STRUCTURE --}}
																{{-- <div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																		<input type="hidden" name="family_id" value="{{ $family->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2 center">
																				Date Weaned:
																				@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  >
																					</div>
																				@else
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																					</div>
																				@endif
																			</div>
																			<div class="col s8 offset-s2 center">
																				Weaning Weight, kg:
																				<div class="input-field inline">
																					<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div> --}}
												        		{!! Form::close() !!}
															</td>
														@else
														{{-- with weaning weight --}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															{{-- <div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div> --}}
															{!! Form::close() !!}
														@endif
													@endif
												@endif
											@endif
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
					{{-- GROUP WEIGHING IS DISPLAYED --}}
					{!! Form::open(['route' => 'farm.pig.add_sowlitter_record_group', 'method' => 'post']) !!}
					<div id="group_weighing" class="row center" style="display: block;">
						<h5 class="green darken-3 white-text">Group Weighing</h5>
						<input type="hidden" name="grouping_id" value="{{ $family->id }}">
						@if(!is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
							<input id="hidden_date" type="hidden" name="date_farrowed" value="{{ $family->getGroupingProperties()->where("property_id", 3)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
							<input id="parity" type="hidden" name="parity" value="{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
							<input id="number_stillborn" type="hidden" name="number_stillborn" value="{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
							<input id="number_mummified" type="hidden" name="number_mummified" value="{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}">
						@endif
						@if(!is_null($family->getGroupingProperties()->where("property_id", 47)->first()))
							<input type="hidden" name="abnomalities" value="{{ $family->getGroupingProperties()->where("property_id", 47)->first()->value }}">
						@endif
						<div class="row">
							<div class="col s4 offset-s2">
								Litter Birth Weight, kg
								@if(!is_null($family->getGroupingProperties()->where("property_id", 55)->first()))
									<div class="input-field inline">
										<input id="litter_birth_weight" type="number" name="litter_birth_weight" value="{{ $family->getGroupingProperties()->where("property_id", 55)->first()->value }}" min="0.000" step="0.001">
									</div>
								@else
									<div class="input-field inline">
										<input id="litter_birth_weight" type="number" name="litter_birth_weight" min="0.000" step="0.001">
									</div>
								@endif
							</div>
							<div class="col s4">
								Litter-size Born Alive
								@if(!is_null($family->getGroupingProperties()->where("property_id", 50)->first()))
									<div class="input-field inline">
										<input id="lsba" type="text" name="lsba" value="{{ $family->getGroupingProperties()->where("property_id", 50)->first()->value }}">
									</div>
								@else
									<div class="input-field inline">
										<input id="lsba" type="text" name="lsba">
									</div>
								@endif
							</div>
						</div>
						<h5 class="green lighten-1">Add offspring</h5>
						<div class="row">
							<div class="col s4 push-s2">
								<input id="offspring_earnotch" type="text" name="offspring_earnotch" class="validate" data-length="6">
								<label for="offspring_earnotch">Offspring Earnotch</label>
								<input type="hidden" name="option" value="0">
							</div>
							<div class="col s4 push-s2">
								<select id="select_sex" name="sex" class="browser-default">
									<option disabled selected>Choose sex</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
						</div>
						<div class="row center">
							<button class="btn waves-effect waves-light green darken-3" type="submit">Add
		            <i class="material-icons right">add</i>
		          </button>
		          {!! Form::close() !!}
						</div>
						<div class="row center">
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
											{!! Form::open(['route' => 'farm.pig.edit_temporary_registryid', 'method' => 'post']) !!}
											<tr>
												@if($offspring->getChild()->status == "temporary")
													<td>
														{{ $offspring->getChild()->registryid }} <a href="#edit_temp_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a>
													</td>
												@else
													<td>
														{{ $offspring->getChild()->registryid }} {{-- <a href="#edit_temp_id{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a> --}}
													</td>
												@endif
												{{-- MODAL STRUCTURE --}}
												<div id="edit_temp_id{{$offspring->getChild()->id}}" class="modal">
													<div class="modal-content">
														<h5 class="center">Edit Temporary Earnotch:<br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
														<input type="hidden" name="old_earnotch" value="{{ $offspring->getChild()->id }}">
														<div class="row center">
															<div class="input-field col s8 offset-s2">
																<input id="new_earnotch" type="text" name="new_earnotch" class="validate" data-length="6">
																<label for="new_earnotch">New Earnotch</label>
															</div>
														</div>
													</div>
													<div class="row center">
														<button class="btn waves-effect waves-light green darken-3" type="submit">
									            Submit <i class="material-icons right">send</i>
									          </button>
													</div>
												</div>
												{!! Form::close() !!}
												{!! Form::open(['route' => 'farm.pig.edit_sex', 'method' => 'post']) !!}
												<td>{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}  <a href="#edit_sex{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></td>
													{{-- MODAL STRUCTURE --}}
													<div id="edit_sex{{$offspring->getChild()->id}}" class="modal">
														<div class="modal-content">
															<h5 class="center">Edit Sex of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
															<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
															<div class="row center">
																<div class="col s8 offset-s2">
																	<select id="new_sex" name="new_sex" class="browser-default">
																		<option disabled selected>Choose sex</option>
																		<option value="M">Male</option>
																		<option value="F">Female</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row center">
															<button class="btn waves-effect waves-light green darken-3" type="submit">
										            Submit <i class="material-icons right">send</i>
										          </button>
														</div>
													</div>
												{!! Form::close() !!}
												<td>{{ round($offspring->getAnimalProperties()->where("property_id", 5)->first()->value, 4) }}</td>
												@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
												{{-- no weaning data --}}
													@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
														{{-- inactive grower --}}
														<td>
															<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
														</td>
													@else
														@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
															{{-- no weaning weight yet --}}
															<td>
																{{-- 21d+ --}}
																{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																	<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
												          			</a>
												          		{{-- <21d --}}
												        		@else
												        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
												        		@endif
												        		{{-- MODAL STRUCTURE --}}
																<div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																		<input type="hidden" name="family_id" value="{{ $family->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2 center">
																				Date Weaned:
																				@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  >
																					</div>
																				@else
																					<div class="input-field inline">
																						<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																					</div>
																				@endif
																			</div>
																			<div class="col s8 offset-s2 center">
																				Weaning Weight, kg:
																				<div class="input-field inline">
																					<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div>
												        		{!! Form::close() !!}
															</td>
														@else
															{{-- with weaning weight --}}
															{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
															<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
															{{-- MODAL STRUCTURE --}}
															<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																<div class="modal-content">
																	<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																	<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																	<div class="row center">
																		<div class="col s8 offset-s2">
																			<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																		</div>
																	</div>
																</div>
																<div class="row center">
																	<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
												          			</button>
																</div>
															</div>
															{!! Form::close() !!}
														@endif
													@endif
												@else
												{{-- with weaning data --}}
													@if($family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
													{{-- all offsprings dead/sold before weaning --}}
														<td>
															<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
														</td>
													@else
													{{-- if at least 1 offspring is alive --}}
														@if($offspring->getChild()->status == "dead grower" || $offspring->getChild()->status == "sold grower" || $offspring->getChild()->status == "removed grower")
															{{-- inactive grower --}}
															@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
																<td>
																	<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Inactive grower (dead/sold/removed)" style="vertical-align: middle;">info_outline</i>
																</td>
															@else
															{{-- active with weaning weight--}}
																{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
																<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
																{{-- MODAL STRUCTURE --}}
																<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2">
																				<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div>
																{!! Form::close() !!}
															@endif
														@else
															{{-- no weaning weight yet --}}
															@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
																<td>
																	{{-- 21d+ --}}
																	{!! Form::open(['route' => 'farm.pig.get_weaning_weights', 'method' => 'post']) !!}
																	@if($now->gte(Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(21)))
																		<a class="btn waves-effect waves-light green darken-3 modal-trigger" href="#weaning_weight_modal{{$offspring->getChild()->id}}">Add <i class="material-icons right">add</i>
													          			</a>
													          		{{-- <21d --}}
													        		@else
													        			<a class="btn disabled">Add <i class="material-icons right">add</i></a> <i class="material-icons tooltipped" data-position="top" data-tooltip="Disabled until 21 days after date farrowed" style="vertical-align: middle;">info_outline</i>
													        		@endif
													        		{{-- MODAL STRUCTURE --}}
																	<div id="weaning_weight_modal{{$offspring->getChild()->id}}" class="modal">
																		<div class="modal-content">
																			<h5 class="center">Weaning Record: <strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																			<input type="hidden" name="offspring_id" value="{{ $offspring->getChild()->id }}">
																			<input type="hidden" name="family_id" value="{{ $family->id }}">
																			<div class="row center">
																				<div class="col s8 offset-s2 center">
																					Date Weaned:
																					@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
																						<div class="input-field inline">
																							<input id="date_weaned" type="date" name="date_weaned"  >
																						</div>
																					@else
																						<div class="input-field inline">
																							<input id="date_weaned" type="date" name="date_weaned"  value="{{ $family->getGroupingProperties()->where("property_id", 6)->first()->value }}">
																						</div>
																					@endif
																				</div>
																				<div class="col s8 offset-s2 center">
																					Weaning Weight, kg:
																					<div class="input-field inline">
																						<input id="weaning_weight" type="number" name="weaning_weight" min="0.001" max="15.999" step="0.001">
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="row center">
																			<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
														          			</button>
																		</div>
																	</div>
													        		{!! Form::close() !!}
																</td>
															@else
															{{-- with weaning weight --}}
																{!! Form::open(['route' => 'farm.pig.edit_weaning_weight', 'method' => 'post']) !!}
																<td>{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }} <a href="#edit_weaning_weight{{$offspring->getChild()->id}}" class="modal-trigger"><i class="material-icons right">edit</i></a></td>
																{{-- MODAL STRUCTURE --}}
																<div id="edit_weaning_weight{{$offspring->getChild()->id}}" class="modal">
																	<div class="modal-content">
																		<h5 class="center">Edit Weaning Weight of <br><strong>{{ $offspring->getChild()->registryid }}</strong></h5>
																		<input type="hidden" name="animalid" value="{{ $offspring->getChild()->id }}">
																		<div class="row center">
																			<div class="col s8 offset-s2">
																				<input id="new_weaning_weight" type="number" name="new_weaning_weight" min="0.001" max="15.999" step="0.001">
																			</div>
																		</div>
																	</div>
																	<div class="row center">
																		<button class="btn waves-effect waves-light green darken-3" type="submit">Submit <i class="material-icons right">send</i>
													          			</button>
																	</div>
																</div>
																{!! Form::close() !!}
															@endif
														@endif
													@endif
												@endif
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
				@endif
			@endif
		</div>
		<div class="fixed-action-btn">
      <a class="btn-floating btn-large green darken-4">
        <i class="large material-icons">cloud_download</i>
      </a>
      <ul>
        <li><a href="{{ URL::route('farm.pig.sowlitter_record_download_csv', [$family->id]) }}" class="btn-floating green lighten-1 tooltipped" data-position="left" data-tooltip="Download as CSV File"><i class="material-icons">table_chart</i></a></li>
        <li><a href="{{ URL::route('farm.pig.sowlitter_record_download_pdf', [$family->id]) }}" class="btn-floating green darken-1 tooltipped" data-position="left" data-tooltip="Download as PDF"><i class="material-icons">file_copy</i></a></li>
      </ul>
    </div>
	</div>
@endsection

@section('scripts')
	<script>
		/*$("#date_farrowed").pickadate({
			format: 'yyyy-mm-dd',
			min: new Date(<?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(109)->format('Y') ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(109)->format('m')-1 ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(109)->format('d') ?>),
			max: new Date()
		});
		$("#datefarrowed").pickadate({
			format: 'yyyy-mm-dd',
			min: new Date(<?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(109)->format('Y') ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(109)->format('m')-1 ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(109)->format('d') ?>),
			max: new Date()
		});
		$("#date_weaned").pickadate({
			format: 'yyyy-mm-dd',
			min: new Date(<?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(130)->format('Y') ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(130)->format('m')-1 ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(130)->format('d') ?>),
			max: new Date()
		});
		$("#dateweaned").pickadate({
			format: 'yyyy-mm-dd',
			min: new Date(<?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(130)->format('Y') ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(130)->format('m')-1 ?>, <?php echo Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->addDays(130)->format('d') ?>),
			max: new Date()
		});*/
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
		$(document).ready(function(){
	      $('.fixed-action-btn').floatingActionButton();
	    });
		$(document).ready(function(){
		  $("#datefarrowed").change(function (event) {
		    // event.preventDefault();
		    var familyidvalue = $('input[name=grouping_id]').val();
		    var datefarrowedvalue = $('input[name=date_farrowed]').val();
		    $.ajax({
		    	headers: {
          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
		      url: '../fetch_date_farrowed/'+familyidvalue+'/'+datefarrowedvalue,
		      type: 'POST',
		      cache: false,
		      data: {familyidvalue, datefarrowedvalue},
		      success: function(data)
		      {
		        Materialize.toast('Date Farrowed successfully added!', 4000);
		      }
		    });
		  });
		  $("#dateweaned").change(function (event) {
		    // event.preventDefault();
		    var familyidvalue = $('input[name=grouping_id]').val();
		    var dateweanedvalue = $('input[name=date_weaned]').val();
		    $.ajax({
		    	headers: {
          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
		      url: '../fetch_date_weaned/'+familyidvalue+'/'+dateweanedvalue,
		      type: 'POST',
		      cache: false,
		      data: {familyidvalue, dateweanedvalue},
		      success: function(data)
		      {
		        Materialize.toast('Date Weaned successfully added!', 4000);
		      }
		    });
		  });
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
		  $("#number_stillborn").change(function (event) {
		    event.preventDefault();
		    var familyidvalue = $('input[name=grouping_id]').val();
		    var stillbornvalue = $('input[name=number_stillborn]').val();
		    $.ajax({
		    	headers: {
          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
		      url: '../fetch_stillborn/'+familyidvalue+'/'+stillbornvalue,
		      type: 'POST',
		      cache: false,
		      data: {familyidvalue, stillbornvalue},
		      success: function(data)
		      {
		        Materialize.toast('Number stillborn successfully added!', 4000);
		      }
		    });
		  });
		  $("#number_mummified").change(function (event) {
		    event.preventDefault();
		    var familyidvalue = $('input[name=grouping_id]').val();
		    var mummifiedvalue = $('input[name=number_mummified]').val();
		    $.ajax({
		    	headers: {
          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
		      url: '../fetch_mummified/'+familyidvalue+'/'+mummifiedvalue,
		      type: 'POST',
		      cache: false,
		      data: {familyidvalue, mummifiedvalue},
		      success: function(data)
		      {
		        Materialize.toast('Number mummified successfully added!', 4000);
		      }
		    });
		  });
		  $("#weighing_options").change(function(event) {
		  	if($(this).is(":checked")){
		  		document.getElementById("individual_weighing1").style.display = "block";
		  		document.getElementById("individual_weighing2").style.display = "block";
		  		document.getElementById("individual_weighing3").style.display = "block";
		  		document.getElementById("group_weighing").style.display = "none";
		  		event.preventDefault();
		   		var familyidvalue = $('input[name=grouping_id]').val();
		    	var option = 1;
		    	$.ajax({
		    		headers: {
	          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	          },
			      url: '../fetch_weighing_option/'+familyidvalue+'/'+option,
			      type: 'POST',
			      cache: false,
			      data: {familyidvalue, option},
			      success: function(data)
			      {
			        Materialize.toast('Enabled individual weighing!', 4000);
			      }
		    	});
		  	}
		  	if(!$(this).is(":checked")){
		  		document.getElementById("group_weighing").style.display = "block";
		  		document.getElementById("individual_weighing1").style.display = "none";
		  		document.getElementById("individual_weighing2").style.display = "none";
		  		document.getElementById("individual_weighing3").style.display = "none";
		  		event.preventDefault();
		   		var familyidvalue = $('input[name=grouping_id]').val();
		    	var option = 0;
		    	$.ajax({
		    		headers: {
	          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	          },
			      url: '../fetch_weighing_option/'+familyidvalue+'/'+option,
			      type: 'POST',
			      cache: false,
			      data: {familyidvalue, option},
			      success: function(data)
			      {
			        Materialize.toast('Enabled group weighing!', 4000);
			      }
		    	});
		  	}
		  });
		});
	</script>
@endsection
