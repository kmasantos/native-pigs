@extends('layouts.swinedefault')

@section('title')
	Pedigree Visualizer
@endsection

@section('initScriptsAndStyles')
	<link type="text/css" rel="stylesheet" href="{{asset('css/pedigree-visualizer-2.0/style.css')}}"  media="screen,projection"/>
@endsection

@section('content')
	<div style="padding-left:200px;">
		<div id="mainDiv"></div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('js/pedigree-visualizer-2.0/d3/d3.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pedigree-visualizer-2.0/pediview.js')}}"></script>

	<script>
		let json = {"registrationnumber":"MARMSCMarinduke-2017F0113-8", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Female","birthyear":"2017", "date_registered": "2017-03-31"}, "quantitative_info": {"weight_at_data_collection": 21, "age_at_data_collection": 6, "birth_weight":0.78, "total_when_born_male": 0, "total_when_born_female": 3, "littersize_born_alive": 3, "parity": 2},"parents": [
		
				{"registrationnumber":"MARMSCMarinduke-2015M0014-4", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Male", "birthyear":"2015", "date_registered": "2015-05-12"}, "quantitative_info": {"weight_at_data_collection": 33.8, "age_at_data_collection": 6, "birth_weight":0.96, "total_when_born_male": 2, "total_when_born_female": 1, "littersize_born_alive": 3, "parity": 2},"parents":[
		
						{"registrationnumber":"MARMSCMarinduke-M000005", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Male"}, "quantitative_info": {"weight_at_data_collection": 33.8, "age_at_data_collection": 6, "birth_weight":0.96, "total_when_born_male": 2, "total_when_born_female": 1, "littersize_born_alive": 3, "parity": 2}},
						{"registrationnumber":"MARMSCMarinduke-F000009", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Female"}, "quantitative_info": {"weight_at_data_collection": 33.8, "age_at_data_collection": 6, "birth_weight":0.96, "total_when_born_male": 2, "total_when_born_female": 1, "littersize_born_alive": 3, "parity": 2}}
					]},
				{"registrationnumber":"MARMSCMarinduke-2015F0017-5", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Female", "birthyear":"2015", "date_registered": "2015-05-21"}, "quantitative_info": {"weight_at_data_collection": 24, "age_at_data_collection": 6, "birth_weight":1.04, "total_when_born_male": 0, "total_when_born_female": 2, "littersize_born_alive": 2, "parity": 1},"parents":[
		
						{"registrationnumber":"MARMSCMarinduke-M000008", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Male"}, "quantitative_info": {"weight_at_data_collection": 33.8, "age_at_data_collection": 6, "birth_weight":0.96, "total_when_born_male": 2, "total_when_born_female": 1, "littersize_born_alive": 3, "parity": 2}},
						{"registrationnumber":"MARMSCMarinduke-F001-36", "qualitative_info":{"farm_name":"MSC","breed":"Marinduke", "sex":"Female"}, "quantitative_info": {"weight_at_data_collection": 33.8, "age_at_data_collection": 6, "birth_weight":0.96, "total_when_born_male": 2, "total_when_born_female": 1, "littersize_born_alive": 3, "parity": 2}}
					]}
			
			]};

		visualize(json);
	</script>
@endsection