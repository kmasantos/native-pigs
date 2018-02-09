@extends('layouts.swinedefault')

@section('title')
  Add Pig
@endsection


@section('content')
  <div class="container">
    <h4><a href="{{route('farm.pig.individual_records')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Add Pig</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
    	{!! Form::open(['route' => 'farm.pig.fetch_new_pig', 'method' => 'post']) !!}
      <div class="col s12">
      	<div class="row">
      		<div class="col s4">
      			<input id="earnotch" type="text" name="earnotch" class="validate" required>
      			<label for="earnotch">Animal Earnotch</label>
      		</div>
      		<div class="col s4">
      			<select id="select_sex" name="sex" class="browser-default" required>
							<option disabled selected>Choose sex</option>
							<option value="M">Male</option>
							<option value="F">Female</option>
						</select>
      		</div>
      		<div class="col s4">
      			<input id="birthday" type="text" placeholder="Pick a date" name="date_farrowed" class="datepicker">
      			<label for="birthday">Birthday</label>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col s4">
      			<input id="birth_weight" type="text" name="birth_weight" class="validate">
      			<label for="birth_weight">Birth weight, kg</label>
      		</div>
    			<div class="col s4">
    				<input id="date_weaned" type="text" placeholder="Pick a date" name="date_weaned" class="datepicker">
      			<label for="date_weaned">Date Weaned</label>
    			</div>
  				<div class="col s4">
  					<input id="weaning_weight" type="text" name="weaning_weight" class="validate">
      			<label for="weaning_weight">Weaning weight, kg</label>
  				</div>
      	</div>
      	<div class="row center">
      		<button class="btn waves-effect waves-light green darken-3" type="submit">Add
            <i class="material-icons right">add</i>
          </button>
      	</div>
     	</div>
     	{!! Form::close() !!}
		</div>
	</div>
@endsection