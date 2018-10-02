@extends('layouts.swinedefault')

@section('title')
	Grower Records
@endsection

@section('content')
	<div class="container">
		<h4>Grower Records <a class="tooltipped" data-position="right" data-tooltip="All pigs except breeders"><i class="material-icons">info_outline</i></a></h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
			<div class="col s12">
        <ul class="tabs tabs-fixed-width green lighten-1">
          <li class="tab"><a href="#femalegrowersview">Female Growers</a></li>
          <li class="tab"><a href="#malegrowersview">Male Growers</a></li>
        </ul>
      </div>
      <div id="femalegrowersview" class="col s12" style="padding-top: 10px;">
				<table class="centered">
					<thead class="green lighten-1">
						<tr>
							<th>Registration ID</th>
							<th>Weight Record</th>
							<th>Average Daily Gain</th>
							<th>Add as Candidate Breeder</th>
							<th>Add as Breeder</th>
						</tr>
					</thead>
					<tbody>
						@forelse($sows as $sow)
							<tr id="{{ $sow->registryid }}">
								<td>{{ $sow->registryid }}</td>
								@if($sow->weightrecord == 0)
                  <td>
                    <a href="{{ URL::route('farm.pig.weight_records_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                  </td>
                @elseif($sow->weightrecord == 1)
                  <td>
                    <a href="{{ URL::route('farm.pig.edit_weight_records_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                  </td>
                @endif
                <td><a href="{{ URL::route('farm.pig.view_adg', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="View ADG"><i class="material-icons">insert_chart_outlined</i></a></td>
                @if(is_null($sow->getAnimalProperties()->where("property_id", 60)->first()))
	                <td>
	                	<div class="switch">
	                		<label>
	                			<input type="checkbox" class="sow_make_candidate_breeder" value="{{ $sow->registryid }}" />
	                			<span class="lever"></span>
	                		</label>
	                	</div>
	                </td>
	              @else
	              	@if($sow->getAnimalProperties()->where("property_id", 60)->first()->value == 1)
	              		<td>
		                	<div class="switch">
		                		<label>
		                			<input checked type="checkbox" class="sow_make_candidate_breeder" value="{{ $sow->registryid }}" />
		                			<span class="lever"></span>
		                		</label>
		                	</div>
		                </td>
	              	@elseif($sow->getAnimalProperties()->where("property_id", 60)->first()->value == 0)
	              		<td>
		                	<div class="switch">
		                		<label>
		                			<input type="checkbox" class="sow_make_candidate_breeder" value="{{ $sow->registryid }}" />
		                			<span class="lever"></span>
		                		</label>
		                	</div>
		                </td>
	              	@endif
	              @endif
								<td>
									<p>
							      <label>
							        <input type="checkbox" class="filled-in add_sow_breeder" value="{{ $sow->registryid }}" />
							        <span></span>
							      </label>
							    </p>
								</td>
							</tr>
						@empty
              <tr>
                <td colspan="5">No female grower data found</td>
              </tr>
            @endforelse
					</tbody>
				</table>
			</div>
			<div id="malegrowersview" class="col s12" style="padding-top: 10px;">
				<table class="centered">
					<thead class="green lighten-1">
						<tr>
							<th>Registration ID</th>
							<th>Weight Record</th>
							<th>Average Daily Gain</th>
							<th>Add as Candidate Breeder</th>
							<th>Add as Breeder</th>
						</tr>
					</thead>
					<tbody>
						@forelse($boars as $boar)
							<tr id="{{ $boar->registryid }}">
								<td>{{ $boar->registryid }}</td>
								@if($boar->weightrecord == 0)
                  <td>
                    <a href="{{ URL::route('farm.pig.weight_records_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                  </td>
                @elseif($boar->weightrecord == 1)
                  <td>
                    <a href="{{ URL::route('farm.pig.edit_weight_records_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                  </td>
                @endif
                <td><a href="{{ URL::route('farm.pig.view_adg', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="View ADG"><i class="material-icons">insert_chart_outlined</i></a></td>
               	@if(is_null($boar->getAnimalProperties()->where("property_id", 60)->first()))
	                <td>
	                	<div class="switch">
	                		<label>
	                			<input type="checkbox" class="boar_make_candidate_breeder" value="{{ $boar->registryid }}" />
	                			<span class="lever"></span>
	                		</label>
	                	</div>
	                </td>
	              @else
	              	@if($boar->getAnimalProperties()->where("property_id", 60)->first()->value == 1)
	              		<td>
		                	<div class="switch">
		                		<label>
		                			<input checked type="checkbox" class="boar_make_candidate_breeder" value="{{ $boar->registryid }}" />
		                			<span class="lever"></span>
		                		</label>
		                	</div>
		                </td>
	              	@elseif($boar->getAnimalProperties()->where("property_id", 60)->first()->value == 0)
	              		<td>
		                	<div class="switch">
		                		<label>
		                			<input type="checkbox" class="boar_make_candidate_breeder" value="{{ $boar->registryid }}" />
		                			<span class="lever"></span>
		                		</label>
		                	</div>
		                </td>
	              	@endif
	              @endif
								<td>
									<p>
							      <label>
							        <input type="checkbox" class="filled-in add_boar_breeder" value="{{ $boar->registryid }}" />
							        <span></span>
							      </label>
							    </p>
								</td>
							</tr>
						@empty
              <tr>
                <td colspan="5">No male grower data found</td>
              </tr>
            @endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
		  $(".add_sow_breeder").change(function () {
		    if($(this).is(":checked")){
					event.preventDefault();
					var breederid = $(this).val();
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: '../farm/fetch_breeders/'+breederid,
						type: 'POST',
						cache: false,
						data: {breederid},
						success: function(data)
						{
							Materialize.toast(breederid+' added as breeder!', 4000);
							$("#"+breederid).remove();
						}
					});
			  }
		  });
		  $(".add_boar_breeder").change(function () {
		    if($(this).is(":checked")){
					event.preventDefault();
					var breederid = $(this).val();
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: '../farm/fetch_breeders/'+breederid,
						type: 'POST',
						cache: false,
						data: {breederid},
						success: function(data)
						{
							Materialize.toast(breederid+' added as breeder!', 4000);
							$("#"+breederid).remove();
						}
					});
			  }
		  });
		  $(".sow_make_candidate_breeder").change(function () {
		  	if($(this).is(":checked")){
		  		event.preventDefault();
		  		var growerid = $(this).val();
		  		var status = 1;
		  		$.ajax({
		  			headers: {
		  				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		  			url: '../farm/make_candidate_breeder/'+growerid+'/'+status,
		  			type: 'POST',
		  			cache: false,
		  			data: {growerid, status},
		  			success: function(data)
		  			{
		  				Materialize.toast(growerid+' added as candidate breeder!', 4000);
		  			}
		  		});
		  	}
		  	if(!$(this).is(":checked")){
		  		event.preventDefault();
		  		var growerid = $(this).val();
		  		var status = 0;
		  		$.ajax({
		  			headers: {
		  				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		  			url: '../farm/make_candidate_breeder/'+growerid+'/'+status,
		  			type: 'POST',
		  			cache: false,
		  			data: {growerid, status},
		  			success: function(data)
		  			{
		  				Materialize.toast(growerid+' removed as candidate breeder!', 4000);
		  			}
		  		});
		  	}
		  });
		  $(".boar_make_candidate_breeder").change(function () {
		  	if($(this).is(":checked")){
		  		event.preventDefault();
		  		var growerid = $(this).val();
		  		var status = 1;
		  		$.ajax({
		  			headers: {
		  				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		  			url: '../farm/make_candidate_breeder/'+growerid+'/'+status,
		  			type: 'POST',
		  			cache: false,
		  			data: {growerid, status},
		  			success: function(data)
		  			{
		  				Materialize.toast(growerid+' added as candidate breeder!', 4000);
		  			}
		  		});
		  	}
		  	if(!$(this).is(":checked")){
		  		event.preventDefault();
		  		var growerid = $(this).val();
		  		var status = 0;
		  		$.ajax({
		  			headers: {
		  				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		  			url: '../farm/make_candidate_breeder/'+growerid+'/'+status,
		  			type: 'POST',
		  			cache: false,
		  			data: {growerid, status},
		  			success: function(data)
		  			{
		  				Materialize.toast(growerid+' removed as candidate breeder!', 4000);
		  			}
		  		});
		  	}
		  });
		});
	</script>
@endsection