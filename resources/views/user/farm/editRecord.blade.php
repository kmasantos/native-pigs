@extends('layouts.farm')

@section('title')
	Native Animals PH | Edit Record
@endsection

@section('content')
	<div class="row">
		<div class="col s12 card-panel">
			<div class="row">
				<div class="col s10 offset-s1 center">
					<h4>Search Record</h4>
					<form>
				        <div class="input-field">
				          <input id="search" type="search" required>
				          <label for="search"><i class="material-icons">search</i></label>
				          <i class="material-icons">close</i>
				        </div>
				    </form>
				</div>
			</div>
			<div class="row">
				<div class="col s10 offset-s1">
					<h4 class="green-text text-darken-4">Sow</h4>
					<div class="row">
						<div class="col s3 offset-s1 center card-panel library">
							<img src="{{asset('images/sow.jpg')}}" height="80" width="80" >
							<p>Sow ID</p>
							<a class="btn btn-flat waves-effect waves-light">Edit</a>
						</div>
						<div class="col s3 offset-s1 center card-panel library">
							<img src="{{asset('images/sow.jpg')}}" height="80" width="80" >
							<p>Sow ID</p>
							<a class="btn btn-flat waves-effect waves-light">Edit</a>
						</div>
						<div class="col s3 offset-s1 center card-panel library">
							<img src="{{asset('images/sow.jpg')}}" height="80" width="80" >
							<p>Sow ID</p>
							<a class="btn btn-flat waves-effect waves-light">Edit</a>
						</div>
					</div>
					<div class="row center">
						<ul class="pagination">
						    <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
						    <li class="active"><a href="#!">1</a></li>
						    <li class="waves-effect"><a href="#!">2</a></li>
						    <li class="waves-effect"><a href="#!">3</a></li>
						    <li class="waves-effect"><a href="#!">4</a></li>
						    <li class="waves-effect"><a href="#!">5</a></li>
						    <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s10 offset-s1">
					<h4 class="green-text text-darken-4">Boar</h4>
					<div class="row">
						<div class="col s3 offset-s1 center card-panel library">
							<img src="{{asset('images/boar.jpg')}}" height="80" width="80" >
							<p>Boar ID</p>
							<a class="btn btn-flat waves-effect waves-light">Edit</a>
						</div>
						<div class="col s3 offset-s1 center card-panel library">
							<img src="{{asset('images/boar.jpg')}}" height="80" width="80" >
							<p>Boar ID</p>
							<a class="btn btn-flat waves-effect waves-light">Edit</a>
						</div>
						<div class="col s3 offset-s1 center card-panel library">
							<img src="{{asset('images/boar.jpg')}}" height="80" width="80" >
							<p>Boar ID</p>
							<a class="btn btn-flat waves-effect waves-light">Edit</a>
						</div>
					</div>
					<div class="row center">
						<ul class="pagination">
						    <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
						    <li class="active"><a href="#!">1</a></li>
						    <li class="waves-effect"><a href="#!">2</a></li>
						    <li class="waves-effect"><a href="#!">3</a></li>
						    <li class="waves-effect"><a href="#!">4</a></li>
						    <li class="waves-effect"><a href="#!">5</a></li>
						    <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection