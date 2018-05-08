@extends('layouts.swinedefault')

@section('title')
	Add as Breeders
@endsection

@section('content')
	<div class="container">
		<h4>Add as Breeders</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
			<div class="col s12">
        <ul class="tabs tabs-fixed-width green lighten-1">
          <li class="tab col s6"><a href="#addsowbreedersview">Sows</a></li>
          <li class="tab col s6"><a href="#addboarbreedersview">Boars</a></li>
        </ul>
      </div>
      <div id="addsowbreedersview" class="col s12">
				<table>
					<thead>
						<tr>
							<th>Registration ID</th>
							<th class="center">Add as Breeder</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sows as $sow)
							<tr id="{{ $sow->id }}">
								<td>{{ $sow->registryid }}</td>
								<td class="center">
									<p>
							      <label>
							        <input id="add_sow_breeder" type="checkbox" class="filled-in" />
							        <span></span>
							      </label>
							      <input type="hidden" name="sow_id" value="{{ $sow->id }}">
							    </p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div id="addboarbreedersview" class="col s12">
				<table>
					<thead>
						<tr>
							<th>Registration ID</th>
							<th class="center">Add as Breeder</th>
						</tr>
					</thead>
					<tbody>
						@foreach($boars as $boar)
							<tr id="{{ $boar->id }}">
								<td>{{ $boar->registryid }}</td>
								<td class="center">
									<p>
							      <label>
							        <input id="add_boar_breeder" type="checkbox" class="filled-in" />
							        <span></span>
							      </label>
							      <input type="hidden" name="boar_id" value="{{ $boar->id }}">
							    </p>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
		  $("#add_sow_breeder").change(function () {
		    if($(this).is(":checked")){
					event.preventDefault();
					var breederid = $('input[name=sow_id]').val();
					console.log(breederid);
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
							Materialize.toast('Sow breeder added!', 4000);
							$("#"+breederid).remove();
						}
					});
			  }
		  });
		  $("#add_boar_breeder").change(function () {
		    if($(this).is(":checked")){
					event.preventDefault();
					var breederid = $('input[name=boar_id]').val();
					console.log(breederid);
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
							Materialize.toast('Boar breeder added!', 4000);
							$("#"+breederid).remove();
						}
					});
			  }
		  });
		});
	</script>
@endsection