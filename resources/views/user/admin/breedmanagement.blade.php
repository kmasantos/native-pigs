@extends('layouts.default')

@section('title')
	Breed Management
@endsection

@section('content')
	<div class="container">
	    <div class="row">
			<h4>Breed Management</h4>
			<div class="divider"></div>
			<div class="row center">
	        	<h5>Data as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
	        	<div class="row center" style="padding-top: 10px;">
		        	@if(isset($error))
				        <div class="row red lighten-3">
							<div class="col s12">
								<h5 class="center">{{ $error }}</h5>
							</div>
				        </div>
				    @elseif(isset($message))
				        <div class="row light-green lighten-3">
							<div class="col s12">
							<h5 class="center">{{ $message }}</h5> 
							</div>
				        </div>
				    @endif
				</div>
	        	<div class="col s12 m10 l12">
	        		<table class="centered striped">
	        			<thead class="green lighten-1">
	        				<tr>
		        				<th>Name</th>
		        				<th>Action</th>
		        			</tr>
	        			</thead>
	        			<tbody>
	        				@forelse($breeds as $breed)
		        				<tr>
		        					<td>{{ $breed->breed }}</td>
		        					<td><a href="#edit_breed{{$breed->id}}" class="tooltipped modal-trigger" data-position="top" data-tooltip="Edit"><i class="fas fa-pencil-alt"></i></a></td>
		        				</tr>
		        				{{-- MODAL STRUCTURE --}}
								<div id="edit_breed{{$breed->id}}" class="modal">
									{!! Form::open(['route' => 'admin.edit_breed', 'method' => 'post']) !!}
									<div class="modal-content">
										<h5 class="center">Edit Breed {{ $breed->breed }}</h5>
										<input type="hidden" name="breed_id" value="{{ $breed->id }}">
										<div class="row center">
											<div class="input-field col s8 m8 l8 offset-s2 offset-m2 offset-l2">
												<input id="name" type="text" name="breed" class="validate" value="{{ $breed->breed }}" required>
												<label for="name">Name</label>
											</div>
										</div>
									</div>
									<div class="row center">
										<button class="btn waves-effect waves-light green darken-3" type="submit">
					            			Submit <i class="material-icons right">send</i>
					          			</button>
									</div>
									{!! Form::close() !!}
								</div>
		        			@empty
		        				<tr>No Breeds Available</tr>
		        			@endforelse
	        			</tbody>
	        		</table>
	        	</div>
			</div>
			<div class="fixed-action-btn">
				<a class="btn-floating btn-large green darken-4 modal-trigger" href="#add_breed">
					<i class="large material-icons">add</i>
				</a>
		    </div>
		    {{-- MODAL STRUCTURE --}}
			<div id="add_breed" class="modal">
				{!! Form::open(['route' => 'admin.fetch_breed', 'method' => 'post']) !!}
				<div class="modal-content">
					<h5 class="center">Add New Breed</h5>
					<div class="row center">
						<div class="input-field col s8 m8 l8 offset-s2 offset-m2 offset-l2">
							<input id="name" type="text" name="new_breed" class="validate" required>
							<label for="name">Name</label>
						</div>
					</div>
				</div>
				<div class="row center">
					<button class="btn waves-effect waves-light green darken-3" type="submit">
            			Submit <i class="material-icons right">send</i>
          			</button>
				</div>
				{!! Form::close() !!}
			</div>
	    </div>
  	</div>
@endsection