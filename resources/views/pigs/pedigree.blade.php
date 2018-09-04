@extends('layouts.swinedefault')

@section('title')
	Pedigree Visualizer
@endsection

@section('initScriptsAndStyles')
	<link type="text/css" rel="stylesheet" href="{{asset('css/pedigree-visualizer/style.css')}}"  media="screen,projection"/>
@endsection

@section('content')
	<div class="container">
		<h4>Pedigree Visualizer</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
			{!! Form::open(['route' => 'farm.pig.find_pig', 'method' => 'post']) !!}
			<div class="col s8 offset-s1">
				<input type="text" id="earnotch" name="earnotch" class="validate">
				<label for="earnotch">Earnotch</label>
			</div>
			<div class="col s2">
				<button class="btn waves-effect waves-light green darken-3" type="submit">Search <i class="material-icons right">search</i></button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	<div style="padding-left:200px;">
		<div id="mainDiv"></div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('js/pedigree-visualizer/d3/d3.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pedigree-visualizer/pediview.js')}}"></script>

	<script>
		let json = {"registrationnumber":"{{ $registrationid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex": "{{ $sex }}","birthyear":"{{ $birthday }}"}, "quantitative_info": {"birth_weight": {{ $birthweight }}, "total_when_born_male": {{ count($malelitters) }} , "total_when_born_female": {{ count($femalelitters) }}, "littersize_born_alive": {{ count($groupingmembers) }}, "parity": {{ $parity }} }, "parents": [
				{"registrationnumber":"{{ $father_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear":"{{ $father_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_birthweight }}, "total_when_born_male": {{ count($father_malelitters) }}, "total_when_born_female": {{ count($father_femalelitters) }}, "littersize_born_alive": {{ count($father_groupingmembers) }}, "parity": {{ $father_parity }} }, "parents":[
		
						{"registrationnumber":"{{ $father_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $father_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandfather_birthweight }} }},
						{"registrationnumber":"{{ $father_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $father_grandmother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $father_grandmother_birthweight }} }}
					]
				},
				{"registrationnumber":"{{ $mother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear":"{{ $mother_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_birthweight }}, "total_when_born_male": {{ count($mother_malelitters) }}, "total_when_born_female": {{ count($mother_femalelitters) }}, "littersize_born_alive": {{ count($mother_groupingmembers) }}, "parity": {{ $mother_parity }} }, "parents":[

						{"registrationnumber":"{{ $mother_grandfather_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Male", "birthyear": "{{ $mother_grandfather_birthday }}"}, "quantitative_info": {"birth_weight": {{ $mother_grandfather_birthweight }} }},
						{"registrationnumber":"{{ $mother_grandmother_registryid }}", "qualitative_info":{"farm_name":"{{ $user->name }}","breed":"{{ $breed->breed }}", "sex":"Female", "birthyear": "{{ $mother_grandmother_birthday }}"}, "quantitative_info": {"birth_weight":{{ $mother_grandmother_birthweight }} }}
					]
				}
			]};

		visualize(json);
	</script>
@endsection