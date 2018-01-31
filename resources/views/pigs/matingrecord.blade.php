@extends('layouts.swinedefault')

@section('title')
	Mating Record
@endsection

@section('content')
	<h4 class="headline">Mating Record</h4>
	<div class="container">
		<div class="row">
			<div class="col s12">
				<div class="row">
					<div class="col s4">
						<select name="month_mating" class="browser-default">
							<option disabled selected>Choose month</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<table class="centered striped responsive-table">
							<thead>
								<tr class="red darken-4 white-text">
									<th>Sow ID</th>
									<th>Boar ID</th>
									<th>Date Bred</th>
									<th>Expected Date of Farrowing</th>
									<th>Recycled</th>
									<th>Date Pregnant</th>
								</tr>
							</thead>
							<tbody>
								@foreach($family as $matingRecord)
									<tr>
										{{-- REGISTRY ID NOT ANIMAL ID --}}
										<td>
											{{ $matingRecord->getMother()->registryid }} 
										</td>
										{{-- REGISTRY ID NOT ANIMAL ID --}}
										<td>
											{{ $matingRecord->getFather()->registryid }}
										</td>
										<td>
											{{ $matingRecord->properties[0]->value }}
										</td>
										<td>
											{{ $matingRecord->properties[1]->value }}
										</td>
										<td>
											@if($matingRecord->properties[3]->value == 0)
												No
											@else
												Yes
											@endif
										</td>
										<td>
											{{ $matingRecord->properties[2]->value }}
										</td>
									</tr>
								@endforeach
                {!! Form::open(['route' => 'farm.pig.get_mating_record', 'method' => 'post']) !!}
								<tr>
									<td>
										<select name="sow_id" class="browser-default">
											<option disabled selected>Choose sow</option>
											@foreach($sows as $sow)	
												<option value="{{ $sow->registryid }}">{{ $sow->registryid }}</option>
											@endforeach
										</select>
									</td>
									<td>
										<select id="boar_id" name="boar_id" class="browser-default">
											<option disabled selected>Choose boar</option>
											@foreach($boars as $boar)
												<option value="{{ $boar->registryid }}">{{ $boar->registryid }}</option>
											@endforeach
										</select>
									</td>
									<td class="input-field">
										<input id="date_bred" type="text" placeholder="Pick date" name="date_bred" class="datepicker">
									</td>
									<td>
										<input id="expected_date_of_farrowing" type="text" placeholder="Pick date" name="expected_date_of_farrowing" class="datepicker">
									</td>
									<td class="switch">
										<label>
											<input type="checkbox" name="recycled" onchange="disableField()">
											<span class="lever"></span>
										</label>
									</td>
									<td>
										<input id="date_pregnant" type="text" placeholder="Pick date" name="date_pregnant" class="datepicker">
									</td>
								</tr>
              </tbody>
						</table>
					</div>
				</div>
				<div class="row center">
					<button class="btn waves-effect waves-light red lighten-2" type="submit">Add
            <i class="material-icons right">add</i>
          </button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
  </div>
@endsection