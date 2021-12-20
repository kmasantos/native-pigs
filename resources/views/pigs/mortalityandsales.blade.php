@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales
@endsection

@section('content')
	<div class="container">
		<h4>Mortality and Sales</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
			{!! Form::open(['route' => 'farm.pig.search_mortality_and_sales', 'method' => 'post', 'role' => 'search']) !!}
      {{ csrf_field() }}
      <div class="input-field col s12">
        <input type="text" name="q" placeholder="Search animal" class="col s9">
        <button type="submit" class="btn green darken-4">Search <i class="material-icons right">search</i></button>
      </div>
      {!! Form::close() !!}
      @if(isset($details))
        <div class="row">
          <div class="col s12">
            <h5 class="center">Search results for <strong>{{ $query }}</strong>:</h5>
            <table class="striped">
              <thead class="green lighten-1">
                <tr>
                  <th class="center">Registration ID</th>
                  <th class="center">Status</th>
                  <th colspan=3 class="center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($details as $search_mortality)
                	<tr>
                		<td>{{ $search_mortality->registryid }}</td>
                		@if($search_mortality->status == "active")
                			<td class="center">Grower</td>
                		@elseif($search_mortality->status == "breeder")
                			<td class="center">Breeder</td>
                		@elseif($search_mortality->status == "dead breeder")
                			<td class="center">Dead Breeder</td>
                		@elseif($search_mortality->status == "sold breeder")
                			<td class="center">Sold Breeder</td>
                		@elseif($search_mortality->status == "removed breeder")
                			<td class="center">Removed Breeder</td>
                		@elseif($search_mortality->status == "dead grower")
                			<td class="center">Dead Grower</td>
                		@elseif($search_mortality->status == "sold grower")
                			<td class="center">Sold Grower</td>
                		@elseif($search_mortality->status == "removed grower")
                			<td class="center">Removed Grower</td>
                		@endif
                		@if($search_mortality->status == "active" || $search_mortality->status == "breeder")
	                		<td class="center"><a href="#mortality{{$search_mortality->id}}" class="tooltipped modal-trigger" data-position="top" data-tooltip="Mortality"><i class="material-icons">clear</i></a></td>
	                		<td class="center"><a href="#sales{{$search_mortality->id}}" class="tooltipped modal-trigger" data-position="top" data-tooltip="Sales"><i class="material-icons">attach_money</i></a></td>
	                		<td class="center"><a href="#remove{{$search_mortality->id}}" class="tooltipped modal-trigger" data-position="top" data-tooltip="Others"><i class="material-icons">remove_circle_outline</i></a></td>
	                	@else
	                		@if($search_mortality->status == "dead breeder" || $search_mortality->status == "dead grower")
	                			<td colspan="3" class="center">{{ Carbon\Carbon::parse(App\Mortality::where("animal_id", $search_mortality->id)->first()->datedied)->format('j F, Y') }}</td>
	                		@elseif($search_mortality->status == "sold breeder" || $search_mortality->status == "sold grower")
	                			<td colspan="3" class="center">{{ Carbon\Carbon::parse(App\Sale::where("animal_id", $search_mortality->id)->first()->datesold)->format('j F, Y') }}</td>
	                		@elseif($search_mortality->status == "removed breeder" || $search_mortality->status == "removed grower")
	                			<td colspan="3" class="center">{{ Carbon\Carbon::parse(App\RemovedAnimal::where("animal_id", $search_mortality->id)->first()->dateremoved)->format('j F, Y') }}</td>
	                		@endif
	                	@endif
                	</tr>
                	{!! Form::open(['route' => 'farm.pig.get_mortality_record', 'method' => 'post']) !!}
                	<div id="mortality{{$search_mortality->id}}" class="modal">
								    <div class="modal-content">
								      <h4>Add <strong>{{ $search_mortality->registryid }}</strong> to Mortality Records</h4>
								      <div class="row">
								      	<input type="hidden" name="animal_id" value="{{ $search_mortality->id }}">
								      	<div class="col s6">
								      		<input id="date_died" type="date" name="date_died" placeholder="Date of Death">
								      	</div>
								      	<div class="col s6">
								      		<input id="cause_death" type="text" class="validate" name="cause_death" placeholder="Cause of Death">
								      	</div>
								      </div>
								      <div class="row center">
								      	<button class="btn waves-effect waves-light green darken-3 tooltipped" data-position="top" data-tooltip="Add mortality record" type="submit">
													Add <i class="material-icons right">add</i>
							          </button>
								      </div>
								    </div>
								  </div>
								  {!! Form::close() !!}
								  {!! Form::open(['route' => 'farm.pig.get_sales_record', 'method' => 'post']) !!}
                	<div id="sales{{$search_mortality->id}}" class="modal">
								    <div class="modal-content">
								      <h4>Add <strong>{{ $search_mortality->registryid }}</strong> to Sales Records</h4>
								      <div class="row">
								      	<input type="hidden" name="animal_id" value="{{ $search_mortality->id }}">
								      	<div class="col s4">
								      		<input id="date_sold" type="date" name="date_sold" placeholder="Date Sold">
								      	</div>
								      	<div class="col s4">
								      		<input id="weight_sold" type="text" class="validate" name="weight_sold" placeholder="Weight Sold, kg">
								      	</div>
								      	<div class="col s4">
								      		<input id="price" type="text" class="validate" name="price" placeholder="Price Sold, Php">
								      	</div>
								      </div>
								      <div class="row center">
								      	<button class="btn waves-effect waves-light green darken-3 tooltipped" data-position="top" data-tooltip="Add sales record" type="submit">
													Add <i class="material-icons right">add</i>
							          </button>
								      </div>
								    </div>
								  </div>
								  {!! Form::close() !!}
								  {!! Form::open(['route' => 'farm.pig.get_removed_animal_record', 'method' => 'post']) !!}
                	<div id="remove{{$search_mortality->id}}" class="modal">
								    <div class="modal-content">
								      <h4>Add <strong>{{ $search_mortality->registryid }}</strong> to Removed Animals Records</h4>
								      <div class="row">
								      	<input type="hidden" name="animal_id" value="{{ $search_mortality->id }}">
								      	<div class="col s6">
								      		<input id="date_removed" type="date" name="date_removed" placeholder="Date Removal">
								      	</div>
								      	<div class="col s6">
								      		<input id="reason_removed" type="text" class="validate" name="reason_removed" placeholder="Cause of Removal">
								      	</div>
								      </div>
								      <div class="row center">
								      	<button class="btn waves-effect waves-light green darken-3 tooltipped" data-position="top" data-tooltip="Add others record" type="submit">
													Add <i class="material-icons right">add</i>
							          </button>
								      </div>
								    </div>
								  </div>
								  {!! Form::close() !!}
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @elseif(isset($message))
        <h5 class="center">{{ $message }}</h5>
      @endif
      <div class="col s12">
				<div class="row">
					<div class="col s12">
						<ul class="tabs tabs-fixed-width green lighten-1">
							<li class="tab"><a href="#mortality_tab">Mortality</a></li>
							<li class="tab"><a href="#sales_tab">Sales</a></li>
							<li class="tab"><a href="#others_tab">Others</a></li>
						</ul>
					</div>
					<div id="mortality_tab" class="col s12" style="padding-top: 10px;">
						<div class="row">
							<div class="col s12">
								<table class="centered striped">
									<thead>
										<tr class="green lighten-1">
											<th>Registration ID</th>
											<th>Date of Death</th>
											<th>Cause of Death</th>
											<th>Age</th>
										</tr>
									</thead>
									<tbody>
										@forelse($deadpigs as $deadpig)
											<tr>
												<td>{{ $deadpig->getRegistryId() }}</td>
												<td>{{ Carbon\Carbon::parse($deadpig->datedied)->format('j F, Y') }}</td>
												<td>{{ $deadpig->cause }}</td>
												@if($deadpig->age != "Age unavailable")
													@if(floor($deadpig->age/30) == 1)
														@if($deadpig->age % 30 == 1)
															<td>{{ floor($deadpig->age/30) }} month, {{ $deadpig->age % 30 }} day</td>
														@else
															<td>{{ floor($deadpig->age/30) }} month, {{ $deadpig->age % 30 }} days</td>
														@endif
													@else
														@if($deadpig->age % 30 == 1)
															<td>{{ floor($deadpig->age/30) }} months, {{ $deadpig->age % 30 }} day</td>
														@else
															<td>{{ floor($deadpig->age/30) }} months, {{ $deadpig->age % 30 }} days</td>
														@endif
													@endif
												@else
													<td>Age unavailable</td>
												@endif
											</tr>
										@empty
											<tr>
												<td colspan="4">No mortality data found</td>
											</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
          </div>
					<div id="sales_tab" class="col s12" style="padding-top: 10px;">
						<div class="row">
							<div class="col s12">
								<table class="centered striped">
									<thead>
										<tr class="green lighten-1">
											<th>Registration ID</th>
											<th>Date Sold</th>
											<th>Weight, kg</th>
											<th>Price, Php</th>
											<th>Age</th>
										</tr>
									</thead>
									<tbody>
										@forelse($soldpigs as $soldpig)
											<tr>
												<td>{{ $soldpig->getRegistryId() }}</td>
												<td>{{ Carbon\Carbon::parse($soldpig->datesold)->format('j F, Y') }}</td>
												<td>{{ $soldpig->weight }}</td>
												<td>{{ $soldpig->price }}</td>
												@if($soldpig->age != "Age unavailable")
													@if(floor($soldpig->age/30) == 1)
														@if($soldpig->age % 30 == 1)
															<td>{{ floor($soldpig->age/30) }} month, {{ $soldpig->age % 30 }} day</td>
														@else
															<td>{{ floor($soldpig->age/30) }} month, {{ $soldpig->age % 30 }} days</td>
														@endif
													@else
														@if($soldpig->ages % 30 == 1)
															<td>{{ floor($soldpig->age/30) }} months, {{ $soldpig->age % 30 }} day</td>
														@else
															<td>{{ floor($soldpig->age/30) }} months, {{ $soldpig->age % 30 }} days</td>
														@endif
													@endif
												@else
													<td>Age unavailable</td>
												@endif
											</tr>
										@empty
											<tr>
												<td colspan="5">No sales record found</td>
											</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
          </div>
          <div id="others_tab" class="col s12" style="padding-top: 10px;">
						<div class="row">
							<div class="col s12">
								<table class="centered striped">
									<thead>
										<tr class="green lighten-1">
											<th>Registration ID</th>
											<th>Date Removed</th>
											<th>Reason</th>
											<th>Age</th>
										</tr>
									</thead>
									<tbody>
										@forelse($removedpigs as $removedpig)
											<tr>
												<td>{{ $removedpig->getRegistryId() }}</td>
												<td>{{ Carbon\Carbon::parse($removedpig->dateremoved)->format('j F, Y') }}</td>
												<td>{{ $removedpig->reason }}</td>
												@if($removedpig->age != "Age unavailable")
													@if(floor($removedpig->age/30) == 1)
														@if($removedpig->age % 30 == 1)
															<td>{{ floor($removedpig->age/30) }} month, {{ $removedpig->age % 30 }} day</td>
														@else
															<td>{{ floor($removedpig->age/30) }} month, {{ $removedpig->age % 30 }} days</td>
														@endif
													@else
														@if($removedpig->age % 30 == 1)
															<td>{{ floor($removedpig->age/30) }} months, {{ $removedpig->age % 30 }} day</td>
														@else
															<td>{{ floor($removedpig->age/30) }} months, {{ $removedpig->age % 30 }} days</td>
														@endif
													@endif
												@else
													<td>Age unavailable</td>
												@endif
											</tr>
										@empty
											<tr>
												<td colspan="4">No removed pig data found</td>
											</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
          </div>
        </div>
      </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
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
		    $('.modal').modal();
		  });
	</script>
@endsection
