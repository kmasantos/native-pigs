@extends('layouts.swinedefault')

@section('title')
	Pedigree Viewer
@endsection

@section('initScriptsAndStyles')
	<link type="text/css" rel="stylesheet" href="{{asset('css/pedigree-visualizer/style.css')}}"  media="screen,projection"/>
@endsection

@section('content')
	<div class="container">
		<h4>Pedigree Viewer</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
    	{!! Form::open(['route' => 'farm.pig.find_pig', 'method' => 'post']) !!}
			<div class="col s8 offset-s1">
				<input type="text" id="earnotch" name="earnotch" class="validate">
				<label for="earnotch">Animal ID</label>
			</div>
			<div class="col s2">
				<button class="btn waves-effect waves-light green darken-3" type="submit">Search <i class="material-icons right">search</i></button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	<div id="mainDiv">
		@if(count($found_pigs) > 0)
			@if($registrationid == "temp")
				<h4 class="center" style="padding-left: 100px;">Found pigs:</h4>
				{!! Form::open(['route' => 'farm.pig.get_selected_pig', 'method' => 'post', 'id' => 'select_pig_id']) !!}
					<select id="select_pig" name="select_pig" class="browser-default" style="width: 53.3333333333%; margin-left: 350px;" onchange="document.getElementById('select_pig_id').submit();">
						<option disabled selected>Select pig</option>
						@foreach($found_pigs as $pig)
							<option value="{{ $pig->id }}">{{ $pig->registryid }} (Born: {{ $pig->getAnimalProperties()->where("property_id", 3)->first()->value }})</option>
						@endforeach
					</select>
				{!! Form::close() !!}
			@endif
			@if($registrationid != "temp" && $group->count() == 0)
				<h4 class="center" style="padding-left: 150px;">{{ $registrationid }}: No parent data</h4>
			@endif
		@elseif(count($found_pigs) == 0)
			@if($animal->count() == 0)
				<h4 class="center" style="padding-left: 150px;">No results available</h4>
			@endif
		@endif
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
	</script>
	<script type="text/javascript" src="{{asset('js/pedigree-visualizer/d3/d3.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pedigree-visualizer/pediview.js')}}"></script>

	<script>
		var animal = "<?php echo $animal->count() ?>";
		
		if(animal != 0){
			var group = "<?php echo $group->count(); ?>";
			if(group != 0){
				var father_group = "<?php echo $father_group->count(); ?>";
				var mother_group = "<?php echo $mother_group->count(); ?>";
				if(father_group == 0 && mother_group != 0){
					var mother_grandfather_group = "<?php echo $mother_grandfather_group->count(); ?>";
					var mother_grandmother_group = "<?php echo $mother_grandmother_group->count(); ?>";
					if(mother_grandfather_group == 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(mother_grandfather_group != 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(mother_grandfather_group != 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(mother_grandfather_group == 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					
				}
				else if(father_group != 0 && mother_group == 0){
					var father_grandfather_group = "<?php echo $father_grandfather_group->count(); ?>";
					var father_grandmother_group = "<?php echo $father_grandmother_group->count(); ?>";
					if(father_grandfather_group == 0 && father_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }
							}
						]};
						visualize(json);
					}
					
				}
				else if(father_group != 0 && mother_group != 0){
					var father_grandfather_group = "<?php echo $father_grandfather_group->count(); ?>";
					var father_grandmother_group = "<?php echo $father_grandmother_group->count(); ?>";
					var mother_grandfather_group = "<?php echo $mother_grandfather_group->count(); ?>";
					var mother_grandmother_group = "<?php echo $mother_grandmother_group->count(); ?>";
					
					if(father_grandfather_group != 0 && father_grandmother_group != 0 && mother_grandfather_group != 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group != 0 && mother_grandfather_group != 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group != 0 && mother_grandfather_group == 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group != 0 && mother_grandfather_group == 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group == 0 && mother_grandfather_group != 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group == 0 && mother_grandfather_group != 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group == 0 && mother_grandfather_group == 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group != 0 && father_grandmother_group == 0 && mother_grandfather_group == 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group != 0 && mother_grandfather_group != 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group != 0 && mother_grandfather_group != 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group != 0 && mother_grandfather_group == 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group != 0 && mother_grandfather_group == 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $father_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $father_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group == 0 && mother_grandfather_group != 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group == 0 && mother_grandfather_group != 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandfather_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandfather_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandfather_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_greatgrandmother_birthweight }} }}
										]
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group == 0 && mother_grandfather_group == 0 && mother_grandmother_group != 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }, "parents":[
					
											{"registrationnumber":"{{ $mother_grandmother_greatgrandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandmother_greatgrandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandfather_birthweight }} }},
											{"registrationnumber":"{{ $mother_grandmother_greatgrandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_greatgrandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandmother_greatgrandmother_birthweight }} }}
										]
									}
								]
							}
						]};
						visualize(json);
					}
					else if(father_grandfather_group == 0 && father_grandmother_group == 0 && mother_grandfather_group == 0 && mother_grandmother_group == 0){
						let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
							{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
					
									{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }}, "total_when_born_male": {{ count($father_grandfather_malelitters) }}, "total_when_born_female": {{ count($father_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($father_grandfather_groupingmembers) }}, "parity": {{ $father_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }}, "total_when_born_male": {{ count($father_grandmother_malelitters) }}, "total_when_born_female": {{ count($father_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($father_grandmother_groupingmembers) }}, "parity": {{ $father_grandmother_parity }} }
									}
								]
							},
							{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[
									{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }}, "total_when_born_male": {{ count($mother_grandfather_malelitters) }}, "total_when_born_female": {{ count($mother_grandfather_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandfather_groupingmembers) }}, "parity": {{ $mother_grandfather_parity }} }
									},
									{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }}, "total_when_born_male": {{ count($mother_grandmother_malelitters) }}, "total_when_born_female": {{ count($mother_grandmother_femalelitters) }}, "littersize_born_alive": {{ count($mother_grandmother_groupingmembers) }}, "parity": {{ $mother_grandmother_parity }} }
									}
								]
							}
						]};
						visualize(json);
					}
				}
				else if(father_group == 0 && mother_group == 0){
					let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
						{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }},
						{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }}
					]};
					visualize(json);
				}
			}
			
		}

	</script>
@endsection