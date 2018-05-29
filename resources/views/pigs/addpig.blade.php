@extends('layouts.swinedefault')

@section('title')
  Add Pig
@endsection


@section('content')
  <div class="container">
    <h4><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Add Pig</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
    	{!! Form::open(['route' => 'farm.pig.fetch_new_pig', 'method' => 'post']) !!}
      <div class="col s12">
        <div class="row">
          <div class="col s6 push-s4">
            Add as
            <input class="with-gap"name="status_setter" type="radio" id="as_breeder" value="breeder" />
            <label for="as_breeder">Breeder</label>
            <input class="with-gap" name="status_setter" type="radio" id="as_grower" value="active" />
            <label for="as_grower">Grower</label>
          </div>
        </div>
      	<div class="row">
      		<div class="col s4">
      			<input id="earnotch" type="text" name="earnotch" class="validate" required>
      			<label for="earnotch">Animal Earnotch *</label>
      		</div>
      		<div class="col s4">
      			<select id="select_sex" name="sex" class="browser-default" required>
							<option disabled selected>Choose sex</option>
							<option value="M">Male</option>
							<option value="F">Female</option>
						</select>
            <label for="select_sex">Sex *</label>
      		</div>
      		<div class="col s4">
      			<input id="birthday" type="text" placeholder="Pick a date" name="date_farrowed" class="datepicker" required>
      			<label for="birthday">Date of Birth *</label>
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
        <div class="row">
          <div class="col s3 offset-s2">
            <input id="mother" type="text" name="mother" class="validate">
            <label for="mother">Mother's Earnotch</label>
          </div>
          <div class="col s3 push-s2">
            <input id="father" type="text" name="father" class="validate">
            <label for="father">Father's Earnotch</label>
          </div>
        </div>
        <div class="divider"></div>
      	<div class="row center">
          <br><sup class="red-text">*required</sup><br>
      		<button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully added!', 4000)">Add
            <i class="material-icons right">add</i>
          </button>
      	</div>
     	</div>
     	{!! Form::close() !!}
		</div>
	</div>
@endsection